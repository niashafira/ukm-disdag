<?php

namespace App\Http\Controllers\Intervensi;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Intervensi;
use App\Models\IntervensiDetail;
use App\Models\Ukm;
use App\Models\UkmTidakTerdaftar;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DataTables;
use Exception;

class PameranController extends Controller
{
    public function index()
    {
        $intervensi = Intervensi::with('intervensiDetail')->where('jenis_intervensi', 'pameran')->orderBy('id', 'DESC')->get();
        return view('intervensi.pameran.index', compact('intervensi'));
    }

    public function create()
    {
        $mode = "create";
        $intervensi = "";
        return view('intervensi.pameran.form', compact('mode', 'intervensi'));
    }

    public function edit($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'pameran')->find($id);

        $mode = "edit";
        return view('intervensi.pameran.form', compact('mode', 'intervensi'));
    }

    public function view($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'pameran')->find($id);

        $mode = "view";
        return view('intervensi.pameran.view', compact('mode', 'intervensi'));
    }

    public function store(Request $request)
    {
        $intervensi = Intervensi::create($request->intervensi);
        $id = $intervensi->id;

        foreach($request->intervensi_detail as $detail){
            unset($detail['readonly']);
            unset($detail['id']);
            $detail['intervensi_id'] = $id;
            IntervensiDetail::create($detail);
        }

        echo json_encode("sukses");
    }

    public function update(Request $request)
    {
        $intervensi = Intervensi::find($request->intervensi['id']);
        $new_intervensi = $request->intervensi;

        unset($new_intervensi['created_at']);
        unset($new_intervensi['updated_at']);
        unset($new_intervensi['intervensi_detail']);
        $intervensi->update($new_intervensi);

        foreach($request->intervensi_detail as $intervensi_d){
            if ($intervensi_d['id'] == "") {
                unset($intervensi_d['id']);
                unset($intervensi_d['readonly']);

                $intervensi_d['intervensi_id'] = $request->intervensi['id'];
                IntervensiDetail::create($intervensi_d);
            }
            else{
                $detail = IntervensiDetail::find($intervensi_d['id']);
                $detail->update($intervensi_d);
            }
        }

        if (count($request->intervensi_detail_delete) != 0) {
            foreach($request->intervensi_detail_delete as $intervensi_d_delete){
                IntervensiDetail::destroy($intervensi_d_delete);
            }
        }

        echo json_encode("sukses");
    }

    public function getListDT(Request $request){
        $data = Intervensi::whereBetween('tanggal_mulai', [$request->input('tanggalMulai'), $request->input('tanggalSelesai')])
                ->where('jenis_intervensi', '=', 'pameran');

        return Datatables::of($data)->make(true);
    }

    public function mainImport(){
        set_time_limit(0);

        $path = storage_path() . "/fix/intervensi_2019.json";
        $json = json_decode(file_get_contents($path), true);

        DB::beginTransaction();

        try{
            for ($i=0; $i < count($json); $i++) {
                $json[$i]['peserta'] = $this->getUkmTerdaftar($json[$i]['excel']);
            }

            for ($i=0; $i < count($json); $i++) {
                $intervensi = Intervensi::create($json[$i]['intervensi']);
                for ($j=0; $j < count($json[$i]['peserta']['terdaftar']); $j++) {
                    $this->saveIntervensiDetail($intervensi->id, $json[$i]['peserta']['terdaftar'][$j]);
                }

                for ($j=0; $j < count($json[$i]['peserta']['tidak_terdaftar']); $j++) {
                    $json[$i]['peserta']['tidak_terdaftar'][$j]['intervensi_id'] = $intervensi->id;
                    UkmTidakTerdaftar::create($json[$i]['peserta']['tidak_terdaftar'][$j]);
                }
            }

            DB::commit();

            return response()->json([
                'data' => $json
            ]);

        } catch(Exception $e){
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

    function getUkmTerdaftar($excel){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path() . "/fix/intervensi.xlsx");
        $spreadsheet->setActiveSheetIndex($excel['sheet']);

        $dataArray = $spreadsheet->getActiveSheet()->rangeToArray($excel['start'] . ':' . $excel['end'],NULL,TRUE,TRUE,TRUE);
        $peserta['terdaftar'] = [];
        $peserta['jml_terdaftar'] = 0;
        $peserta['tidak_terdaftar'] = [];
        $peserta['jml_tidak_terdaftar'] = 0;

        foreach ($dataArray as $index => $ukm) {
            $ukm['G'] = ltrim($ukm['G'], '‘');
            $dataArray[$index]['G'] = $ukm['G'];
            $ukm['G'] = str_replace("'","",$ukm['G']);

            $check_ukm_nik = Ukm::where('nik', '=', $ukm['G'])->first();
            $check_ukm_nama = Ukm::whereRaw("lower(nama_usaha) = (?) and lower(nama_pemilik) = (?)", [strtolower($ukm['E']), mb_strtolower($ukm['F'])])->first();

            if(isset($check_ukm_nik->id)){
                array_push($peserta['terdaftar'], $check_ukm_nik);
                $peserta['jml_terdaftar']++;
            }
            elseif(isset($check_ukm_nama->id)) {
                array_push($peserta['terdaftar'], $check_ukm_nama);
                $peserta['jml_terdaftar']++;
            }
            else{
                array_push($peserta['tidak_terdaftar'], [
                    'nama_usaha' => $ukm['E'],
                    "nama_pemilik" => $ukm['F'],
                    "nik" => $ukm['G'],
                    "alamat" => $ukm['H'],
                    "no_telp" => $ukm['I'],
                    "isActive" => false,
                ]);
                $peserta['jml_tidak_terdaftar']++;
            }

        }

        return $peserta;
    }

    function saveIntervensiDetail($intervensi_id, $ukm){
        $input['ukm_id'] = $ukm->id;
        $input['intervensi_id'] = $intervensi_id;

        IntervensiDetail::create($input);
    }

    // public function importUkmIntervensi(){
    //     $start = "E740";
    //     $end = "H749";
    //     $intervensi_id = 159;

    //     $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path() . "/data/intervensi2.xlsx");
    //     $spreadsheet->setActiveSheetIndex(4);

    //     $dataArray = $spreadsheet->getActiveSheet()->rangeToArray($start . ':' . $end,NULL,TRUE,TRUE,TRUE);

    //     $ukm_binaan = [];
    //     $ukm_non_binaan = [];
    //     foreach ($dataArray as $index => $ukm) {
    //         $input = [];
    //         $ukm['G'] = ltrim($ukm['G'], '‘');
    //         $dataArray[$index]['G'] = $ukm['G'];

    //         $check_ukm_nik = DB::select("select * from ukm_disdag.ukm
    //         where nik = ''
    //         or (lower(nama_pemilik) = '". strtolower($ukm['F']) ."' and lower(nama_usaha) = '". strtolower($ukm['E']) ."')");

    //         if(isset($check_ukm_nik[0]->id)){
    //             array_push($ukm_binaan, $check_ukm_nik[0]);
    //             $input['ukm_id'] = $check_ukm_nik[0]->id;
    //             $input['ukm_nama'] = $check_ukm_nik[0]->nama_usaha;
    //             $input['intervensi_id'] = $intervensi_id;
    //             $input['status_binaan'] = true;
    //         }
    //         else{
    //             array_push($ukm_non_binaan, ['ukm_nama' => $ukm['E']]);
    //             $input['ukm_nama'] = $ukm['E'];
    //             $input['intervensi_id'] = $intervensi_id;
    //             $input['status_binaan'] = false;
    //         }

    //         IntervensiDetail::create($input);

    //     }

    //     echo json_encode($ukm_binaan);

    // }

    public function exportExcel(Request $request){
        $intervensi = Intervensi::find($request->id);
        $fields = $request['field'];
        $field_query = "a.keterangan, a.ukm_nama, ";

        for ($i=0; $i < count($fields); $i++) {
            $field_query .= "b.{$fields[$i]['key']}";
            if($i != count($fields)-1){
                $field_query .= ", ";
            }
        }

        $data = DB::select("
            SELECT {$field_query}
            from ukm_disdag.intervensi_detail AS a
            LEFT JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id
            WHERE a.intervensi_id = {$request['id']}
            ORDER BY b.nama_usaha ASC"
        );

        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue("A1", "Nama Pelatihan : {$intervensi['nama_intervensi']}");
        $sheet->setCellValue("A2", "Lokasi : {$intervensi['lokasi']}");
        if(date("d-m-Y", strtotime($intervensi['tanggal_mulai'])) != null){
            $tanggal_mulai = date("d-m-Y", strtotime($intervensi['tanggal_mulai']));
        }
        if(date("d-m-Y", strtotime($intervensi['tanggal_selesai'])) != null){
            $tanggal_selesai = date("d-m-Y", strtotime($intervensi['tanggal_selesai']));
        }
        $sheet->setCellValue("A3", "Tanggal Mulai : " . $tanggal_mulai);
        $sheet->setCellValue("A4", "Tanggal Selesai : " . $tanggal_selesai);
        $sheet->setCellValue("A5", "Deskripsi : {$intervensi['deskripsi']}");
        $sheet->setCellValue("A6", "Jumlah Peserta : " . count($data));

        $sheet->setCellValue("A8", "No");
        $col = "B";
        $cols = [];
        for ($i=0; $i < count($fields); $i++) {
            $sheet->setCellValue("{$col}8", $fields[$i]['value']);
            $spreadsheet->getActiveSheet()->getColumnDimension("{$col}")->setWidth(30);
            $fields[$i]['cell'] = $col;
            array_push($cols, $col);
            if($i != count($fields)-1){
                $col++;
            }
        }
        $sheet->getStyle("A8:{$col}8")->applyFromArray($this->styleExcel("header"));

        $num_col = 9;
        for ($i=0; $i < count($data); $i++) {
            $sheet->setCellValue("A{$num_col}", $i+1);
            $spreadsheet->getActiveSheet()->getStyle("A{$num_col}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            for ($j=0; $j < count($fields); $j++) {
                $key = $fields[$j]['key'];
                $value = $data[$i]->$key;
                if($key == 'nik' && $data[$i]->$key != null){
                    $value = "'" . $data[$i]->$key;
                }

                $sheet->setCellValue("{$fields[$j]['cell']}{$num_col}", $value);
                if($fields[$j]['key'] == 'nama_usaha' && $data[$i]->$key == null){
                    $sheet->setCellValue("{$fields[$j]['cell']}{$num_col}", $data[$i]->ukm_nama);
                }
                $spreadsheet->getActiveSheet()->getStyle("{$fields[$j]['cell']}{$num_col}")->getAlignment()->setWrapText(true);
                $spreadsheet->getActiveSheet()->getStyle("{$fields[$j]['cell']}{$num_col}")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            }
            $num_col++;
        }
        $col--;
        $num_col--;
        $sheet->getStyle("A8:{$col}{$num_col}")->applyFromArray($this->styleExcel("all_border"));

        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();

        return response()->json(
            [
                'status' => "S",
                'data' => $data,
                'fields' => $fields,
                'excel' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            ]
        );

    }

    function styleExcel($type){
        if($type == "all_border"){
            return [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];
        }

        else if($type == "header"){
            return [
                'font' => [
                    'bold' => true,
                    'color' => 	array('rgb' => 'FFFFFF')
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => '663259',
                    ]
                ],
            ];
        }

    }

}

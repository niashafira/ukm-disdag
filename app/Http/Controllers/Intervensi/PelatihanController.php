<?php

namespace App\Http\Controllers\Intervensi;

use App\Http\Controllers\Controller;
use App\Models\Intervensi;
use App\Models\IntervensiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use DataTables;
use Exception;

class PelatihanController extends Controller
{
    public function index()
    {
        return view('intervensi.pelatihan.index');
    }

    public function create()
    {
        $intervensi = "";
        $mode = "create";
        return view('intervensi.pelatihan.form', compact('mode','intervensi'));
    }

    public function edit($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'pelatihan')->find($id);
        $intervensi_detail = IntervensiDetail::where('intervensi_id', $id)->get();

        $intervensi['intervensi_detail'] = $intervensi_detail;

        $mode = "edit";
        return view('intervensi.pelatihan.form', compact('mode', 'intervensi'));
    }

    public function view($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'pelatihan')->find($id);

        $mode = "view";
        return view('intervensi.pelatihan.view', compact('mode', 'intervensi'));
    }

    //API SECTION

    public function store(Request $request)
    {
        $intervensi = Intervensi::create($request->intervensi);
        $id = $intervensi->id;

        foreach($request->intervensi_detail as $detail){
            unset($detail['readonly']);
            unset($detail['nama_usaha']);
            unset($detail['id']);
            $detail['intervensi_id'] = $id;
            IntervensiDetail::create($detail);
        }

        echo json_encode("sukses");
    }

    public function getListDT(Request $request){
        $data = Intervensi::whereBetween('tanggal_mulai', [$request->input('tanggalMulai'), $request->input('tanggalSelesai')])
                ->where('jenis_intervensi', '=', 'pelatihan');

        return Datatables::of($data)->make(true);
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
                unset($intervensi_d['nama_usaha']);

                $intervensi_d['intervensi_id'] = $request->intervensi['id'];
                IntervensiDetail::create($intervensi_d);
            }
            else{
                $detail = IntervensiDetail::find($intervensi_d['id']);
                unset($intervensi_d['nama_usaha']);
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

    public function exportExcel(Request $request){
        $pelatihan = Intervensi::find($request->id);
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
        $sheet->setCellValue("A1", "Nama Pelatihan : {$pelatihan['nama_intervensi']}");
        $sheet->setCellValue("A2", "Lokasi : {$pelatihan['lokasi']}");
        if(date("d-m-Y", strtotime($pelatihan['tanggal_mulai'])) != null){
            $tanggal_mulai = date("d-m-Y", strtotime($pelatihan['tanggal_mulai']));
        }
        if(date("d-m-Y", strtotime($pelatihan['tanggal_selesai'])) != null){
            $tanggal_selesai = date("d-m-Y", strtotime($pelatihan['tanggal_selesai']));
        }
        $sheet->setCellValue("A3", "Tanggal Mulai : " . $tanggal_mulai);
        $sheet->setCellValue("A4", "Tanggal Selesai : " . $tanggal_selesai);
        $sheet->setCellValue("A5", "Deskripsi : {$pelatihan['deskripsi']}");
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

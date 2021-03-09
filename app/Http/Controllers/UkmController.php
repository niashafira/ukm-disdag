<?php

namespace App\Http\Controllers;

use App\Models\Omset;
use App\Models\Ukm;
use Illuminate\Http\Request;
use Mockery\Undefined;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \stdClass;

class UkmController extends Controller
{

    public function index()
    {
        $ukm = Ukm::get();
        return view('ukm.index', compact('ukm'));
    }

    public function create()
    {
        $mode = "create";
        return view("ukm.form", compact('mode'));
    }

    public function store(Request $request)
    {
        $ukm = Ukm::create($request->ukm);
        $id = $ukm->id;

        foreach($request->omset as $omset){
            $omset['ukm_id'] = $id;
            Omset::create($omset);
        }

        echo json_encode("sukses");
    }

    public function show($id)
    {
        $data = Ukm::find($id);
        return view("ukm.view", compact('data'));
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $mode = "edit";
        $data = Ukm::find($id);
        return view("ukm.modal-form", compact('mode', 'data'));
    }

    public function update(Request $request)
    {

    }

    public function destroy(Request $request)
    {

    }

    public function getAll(){
        $data_ukm = Ukm::get();

        return response()->json($data_ukm);
    }

    public function importExcel(){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('doc/umkm_baru.xlsx'));
        $spreadsheet->setActiveSheetIndex(1);

        $dataArray = $spreadsheet->getActiveSheet()->rangeToArray('B2:AP1402',NULL,TRUE,TRUE,TRUE);

        $data_ukm = [];
        $duplicate_ukm = [];
        $index_data_ukm = 0;
        foreach($dataArray as $ukm){
            $new_ukm = true;
            foreach ($data_ukm as $exist_ukm) {
                if(strtolower($ukm['D']) == strtolower($exist_ukm['nama_pemilik']) || strtolower($ukm['B']) == strtolower($exist_ukm['nama_usaha'])){
                    $new_ukm = false;
                    $new_duplicate = true;
                    foreach($duplicate_ukm as $index_dup => $dup_ukm){
                        if (strtolower($ukm['D']) == strtolower($dup_ukm['original']['nama_pemilik']) || strtolower($ukm['B']) == strtolower($dup_ukm['original']['nama_usaha'])) {
                            if(strtolower($ukm['D']) == 'sri rahayu'){

                            }
                            $new_dup_ukm = [
                                'nama_usaha' => $ukm['B'],
                                'nama_pemiilk' => $ukm['D'],
                                'nik' => $ukm['E'],
                                'alamat' => $ukm['C'],
                                'no_telp' => $ukm['F'],
                                'jangkauan_pemasaran' => $ukm['AK'],
                                'email' => "",
                                'no_siup' => $ukm['J'],
                                'no_nib' => "",
                                'no_tdp' => "",
                                'no_iumk' => "",
                                'no_pirt' => "",
                                'no_bpom' => "",
                                'tahun_binaan' => $ukm['S'],
                                'jumlah_pemodalan' => null,
                                'sumber_pemodalan' => null,
                                'jumlah_pinjaman' => null,
                                'sumber_pinjaman' => null,
                                'no_sertifikasi_halal' => null,
                                'no_sertifikasi_merek' => null,
                                'jenis_produksi' => $ukm['AF'],
                                'is_insert' => false
                            ];

                            array_push($duplicate_ukm[$index_dup]['duplicate'], $new_dup_ukm);

                            $new_duplicate = false;
                        }
                    }
                    if ($new_duplicate == true) {
                        $duplicate['original'] = $exist_ukm;
                        $duplicate['original']['is_insert'] = true;
                        $duplicate['duplicate'] = [];

                        $duplicate_data = [
                            'nama_usaha' => $ukm['B'],
                            'nama_pemiilk' => $ukm['D'],
                            'nik' => $ukm['E'],
                            'alamat' => $ukm['C'],
                            'no_telp' => $ukm['F'],
                            'jangkauan_pemasaran' => $ukm['AK'],
                            'email' => "",
                            'no_siup' => $ukm['J'],
                            'no_nib' => "",
                            'no_tdp' => "",
                            'no_iumk' => "",
                            'no_pirt' => "",
                            'no_bpom' => "",
                            'tahun_binaan' => $ukm['S'],
                            'jumlah_pemodalan' => null,
                            'sumber_pemodalan' => null,
                            'jumlah_pinjaman' => null,
                            'sumber_pinjaman' => null,
                            'no_sertifikasi_halal' => null,
                            'no_sertifikasi_merek' => null,
                            'jenis_produksi' => $ukm['AF'],
                            'is_insert' => false
                        ];

                        array_push($duplicate['duplicate'], $duplicate_data);

                        array_push($duplicate_ukm, $duplicate);
                    }

                }
            }
            if ($new_ukm == true) {
                $data_ukm[$index_data_ukm]['nama_usaha'] = $ukm['B'];
                $data_ukm[$index_data_ukm]['nama_pemilik'] = $ukm['D'];
                $data_ukm[$index_data_ukm]['nik'] = $ukm['E'];
                $data_ukm[$index_data_ukm]['alamat'] = $ukm['C'];
                $data_ukm[$index_data_ukm]['no_telp'] = $ukm['F'];
                $data_ukm[$index_data_ukm]['jangkauan_pemasaran'] = $ukm['AK'];
                $data_ukm[$index_data_ukm]['email'] = "";
                $data_ukm[$index_data_ukm]['no_siup'] = $ukm['J'];
                $data_ukm[$index_data_ukm]['no_nib'] = "";
                $data_ukm[$index_data_ukm]['no_tdp'] = "";
                $data_ukm[$index_data_ukm]['no_iumk'] = "";
                $data_ukm[$index_data_ukm]['no_pirt'] = "";
                $data_ukm[$index_data_ukm]['no_bpom'] = "";
                $data_ukm[$index_data_ukm]['tahun_binaan'] = $ukm['S'];
                $data_ukm[$index_data_ukm]['jumlah_pemodalan'] = null;
                $data_ukm[$index_data_ukm]['sumber_pemodalan'] = null;
                $data_ukm[$index_data_ukm]['jumlah_pinjaman'] = null;
                $data_ukm[$index_data_ukm]['sumber_pinjaman'] = null;
                $data_ukm[$index_data_ukm]['no_sertifikasi_halal'] = null;
                $data_ukm[$index_data_ukm]['no_sertifikasi_merek'] = null;
                $data_ukm[$index_data_ukm]['jenis_produksi'] = $ukm['AF'];

                $index_data_ukm++;
            }
        }
        echo json_encode($duplicate_ukm);
        // echo json_encode($data_ukm);

        foreach ($data_ukm as $exist_ukm) {
            $this->store2($exist_ukm);
        }
    }

    public function importRevisiUkm(){
        $path = storage_path() . "/json/ukm_pemilik_sama_filtered.json";

        $json = json_decode(file_get_contents($path), true);

        // echo json_encode($json);

        $ukm_nik_null = [];

        foreach ($json as $data) {
            if($data['original']['is_insert'] == false){
                $this->deleteUkmDup($data);
            }

            foreach ($data['duplicate'] as $dup) {
                if($dup['is_insert'] == true){
                    unset($dup['is_insert']);
                    $dup['nama_pemilik'] = $dup['nama_pemiilk'];
                    unset($dup['nama_pemiilk']);

                    if($dup['nik'] != null && isset($dup['nik'])){
                        $this->store2($dup);
                    }
                    else {
                        array_push($ukm_nik_null, $dup);
                    }

                }
            }
        }

        echo json_encode($ukm_nik_null);
    }

    public function store2($ukm){
        $ukm = Ukm::create($ukm);
    }

    public function deleteUkmDup($ukm){
        if(isset($ukm['nik'])){
            Ukm::where([
                'nik' => $ukm['nik'],
                'nama_usaha' => $ukm['nama_usaha'],
                'nama_pemilik' => $ukm['nama_pemilik']
            ])->delete();
        }
    }
}

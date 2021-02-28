<?php

namespace App\Http\Controllers;

use App\Models\Omset;
use App\Models\Ukm;
use Illuminate\Http\Request;
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
        //
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

        $index_ukm = 0;
        foreach($dataArray as $ukm) {
            $data_ukm[$index_ukm]['nama_usaha'] = $ukm['B'];
            $data_ukm[$index_ukm]['nama_pemilik'] = $ukm['D'];
            $data_ukm[$index_ukm]['nik'] = $ukm['E'];
            $data_ukm[$index_ukm]['alamat'] = $ukm['C'];
            $data_ukm[$index_ukm]['no_telp'] = $ukm['F'];
            $data_ukm[$index_ukm]['jangkauan_pemasaran'] = $ukm['AK'];
            $data_ukm[$index_ukm]['email'] = "";
            $data_ukm[$index_ukm]['no_siup'] = $ukm['J'];
            $data_ukm[$index_ukm]['no_nib'] = "";
            $data_ukm[$index_ukm]['no_tdp'] = "";
            $data_ukm[$index_ukm]['no_iumk'] = "";
            $data_ukm[$index_ukm]['no_pirt'] = "";
            $data_ukm[$index_ukm]['no_bpom'] = "";
            $data_ukm[$index_ukm]['tahun_binaan'] = $ukm['S'];
            $data_ukm[$index_ukm]['jumlah_pemodalan'] = null;
            $data_ukm[$index_ukm]['sumber_pemodalan'] = null;
            $data_ukm[$index_ukm]['jumlah_pinjaman'] = null;
            $data_ukm[$index_ukm]['sumber_pinjaman'] = null;
            $data_ukm[$index_ukm]['no_sertifikasi_halal'] = null;
            $data_ukm[$index_ukm]['no_sertifikasi_merek'] = null;
            $data_ukm[$index_ukm]['jenis_produksi'] = $ukm['AF'];

            $this->store2($data_ukm[$index_ukm]);

            $index_ukm++;
        }
    }

    public function store2($ukm){
        $ukm = Ukm::create($ukm);
    }
}

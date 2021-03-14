<?php

namespace App\Http\Controllers\Intervensi;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Intervensi;
use App\Models\IntervensiDetail;
use App\Models\Ukm;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PameranController extends Controller
{
    public function index()
    {
        $intervensi = Intervensi::with('intervensiDetail')->where('jenis_intervensi', 'pameran')->orderBy('id', 'DESC')->get();
        return view('intervensi.pameran.index', compact('intervensi'));
    }

    public function create()
    {
        $intervensi = "";
        $mode = "create";
        return view('intervensi.pameran.form', compact('mode','intervensi'));
    }

    public function edit($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'pameran')->find($id);
        $intervensi_detail = IntervensiDetail::where('intervensi_id', $id)->get();

        $intervensi['intervensi_detail'] = $intervensi_detail;

        $mode = "edit";
        return view('intervensi.pameran.form', compact('mode', 'intervensi'));
    }

    public function view($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'pameran')->find($id);
        $intervensi_detail = IntervensiDetail::where('intervensi_id', $id)->get();

        $intervensi['intervensi_detail'] = $intervensi_detail;

        $mode = "view";
        return view('intervensi.pameran.form', compact('mode', 'intervensi'));
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

    public function importUkmIntervensi(){
        $start = "E574";
        $end = "H643";
        $intervensi_id = 65;

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path() . "/data/intervensi.xlsx");
        $spreadsheet->setActiveSheetIndex(3);

        $dataArray = $spreadsheet->getActiveSheet()->rangeToArray($start . ':' . $end,NULL,TRUE,TRUE,TRUE);

        $ukm_binaan = [];
        $ukm_non_binaan = [];
        foreach ($dataArray as $index => $ukm) {
            $input = [];
            $ukm['G'] = ltrim($ukm['G'], '‘');
            $dataArray[$index]['G'] = $ukm['G'];

            $check_ukm_nik = DB::select("select * from ukm_disdag.ukm
            where nik = ''
            or (lower(nama_pemilik) = '". strtolower($ukm['F']) ."' and lower(nama_usaha) = '". strtolower($ukm['E']) ."')");

            if(isset($check_ukm_nik[0]->id)){
                array_push($ukm_binaan, $check_ukm_nik[0]);
                $input['ukm_id'] = $check_ukm_nik[0]->id;
                $input['ukm_nama'] = $check_ukm_nik[0]->nama_usaha;
                $input['intervensi_id'] = $intervensi_id;
                $input['status_binaan'] = true;
            }
            else{
                array_push($ukm_non_binaan, ['ukm_nama' => $ukm['E']]);
                $input['ukm_nama'] = $ukm['E'];
                $input['intervensi_id'] = $intervensi_id;
                $input['status_binaan'] = false;
            }

            IntervensiDetail::create($input);


        }

        echo json_encode($ukm_binaan);

    }

}

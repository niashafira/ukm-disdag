<?php

namespace App\Http\Controllers;

use App\Models\ReferensiDetail;
use App\Models\Referensi;
use Exception;
use Illuminate\Http\Request;

class ReferensiController extends Controller
{

    public function index()
    {
        $referensi = Referensi::get();
        return view('referensi.index', compact('referensi'));
    }

    public function create()
    {
        $mode = "create";
        $referensi = "";
        return view('referensi.form', compact('mode', 'referensi'));
    }

    public function store(Request $request)
    {

        Referensi::create($request->referensi);

        foreach($request->referensi_detail as $refD){
            unset($refD['readonly']);
            unset($refD['id']);
            ReferensiDetail::create($refD);
        }

        echo json_encode("success");
    }

    public function show($id)
    {
        //
    }

    public function edit($ref_id)
    {
        $referensi = Referensi::with('referensiDetail')->find($ref_id);
        $mode = "edit";

        return view('referensi.form', compact('referensi', 'mode'));

    }

    public function view($ref_id)
    {
        $referensi = Referensi::with('referensiDetail')->find($ref_id);
        $mode = "view";

        return view('referensi.form', compact('referensi', 'mode'));

    }

    public function update(Request $request)
    {
        $referensi = Referensi::find($request->referensi['kode']);
        $referensi->update($request->referensi);


        foreach($request->referensi_detail as $refD){
            if ($refD['id'] == "") {
                unset($refD['readonly']);
                unset($refD['id']);
                ReferensiDetail::create($refD);
            }
            else{
                unset($refD['readonly']);
                $referensiD = ReferensiDetail::find($refD['id']);
                $referensiD->update($refD);
            }
        }

        if (count($request->referensi_detail_delete) != 0) {
            foreach($request->referensi_detail_delete as $refD_delete){
                ReferensiDetail::destroy($refD_delete);
            }
        }

        echo json_encode("success");

    }

    public function destroy(Request $request)
    {
        Referensi::destroy($request->kode);
        ReferensiDetail::where('referensi_kode', '=', $request->kode)->delete();

        echo json_encode("success");
    }
}

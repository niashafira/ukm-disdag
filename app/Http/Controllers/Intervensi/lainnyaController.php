<?php

namespace App\Http\Controllers\intervensi;

use App\Http\Controllers\Controller;
use App\Models\Intervensi;
use App\Models\IntervensiDetail;
use Illuminate\Http\Request;

class lainnyaController extends Controller
{
    public function index()
    {
        $intervensi = Intervensi::with('intervensiDetail')->where('jenis_intervensi', 'lainnya')->orderBy('id', 'DESC')->get();
        return view('intervensi.lainnya.index', compact('intervensi'));
    }

    public function create()
    {
        $intervensi = "";
        $mode = "create";
        return view('intervensi.lainnya.form', compact('mode','intervensi'));
    }

    public function edit($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'lainnya')->find($id);
        $intervensi_detail = IntervensiDetail::where('intervensi_id', $id)->get();

        $intervensi['intervensi_detail'] = $intervensi_detail;

        $mode = "edit";
        return view('intervensi.lainnya.form', compact('mode', 'intervensi'));
    }

    public function view($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'lainnya')->find($id);
        $intervensi_detail = IntervensiDetail::where('intervensi_id', $id)->get();

        $intervensi['intervensi_detail'] = $intervensi_detail;

        $mode = "view";
        return view('intervensi.lainnya.form', compact('mode', 'intervensi'));
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
}
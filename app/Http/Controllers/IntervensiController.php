<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Intervensi;
use App\Models\IntervensiDetail;
use Illuminate\Http\Request;

class IntervensiController extends Controller
{

    public function index()
    {
        $intervensi = Intervensi::get();
        return view('intervensi.index', compact('intervensi'));
    }

    public function indexPelatihan()
    {
        $intervensi = Intervensi::with('intervensiDetail')->where('jenis_intervensi', 'pelatihan')->get();
        return view('intervensi.pelatihan.index', compact('intervensi'));
    }

    public function createPelatihan()
    {
        $intervensi = "";
        $mode = "create";
        return view('intervensi.pelatihan.form', compact('mode','intervensi'));
    }

    public function editPelatihan($id)
    {
        $intervensi = Intervensi::where('jenis_intervensi', 'pelatihan')->find($id);
        $intervensi_detail = DB::select("
            SELECT a.id, a.ukm_id, a.intervensi_id, a.keterangan, b.nama_ukm
            from ukm_disdag.intervensi_detail AS a
            INNER JOIN ukm_disdag.data_ukm AS b
            ON b.id = a.ukm_id
            WHERE a.intervensi_id = ". $id .";
        ");

        $intervensi['intervensi_detail'] = $intervensi_detail;

        $mode = "edit";
        return view('intervensi.pelatihan.form', compact('mode', 'intervensi'));
    }

    public function storePelatihan(Request $request)
    {
        $intervensi = Intervensi::create($request->intervensi);
        $id = $intervensi->id;

        foreach($request->intervensi_detail as $detail){
            unset($detail['readonly']);
            unset($detail['nama_ukm']);
            $detail['intervensi_id'] = $id;
            IntervensiDetail::create($detail);
        }

        echo json_encode("sukses");
    }

    public function updatePelatihan(Request $request)
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
                unset($intervensi_d['nama_ukm']);

                $intervensi_d['intervensi_id'] = $request->intervensi['id'];
                IntervensiDetail::create($intervensi_d);
            }
            else{
                $detail = IntervensiDetail::find($intervensi_d['id']);
                unset($intervensi_d['nama_ukm']);
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

    public function create()
    {
        $mode = "create";
        return view("intervensi.form", compact('mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(IntervensiModel::where('jenis','=',$request->jenis)->exists()){
            $response['status'] = "E";
            $response['msg'] = "Jenis intervensi sudah ada sebelumnya";

            return response()->json($response);
        }

        IntervensiModel::create($request->except(["mode"]));
        $response['status'] = "S";
        $response['msg'] = "Data berhasil disimmpan";
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $mode = "edit";
        $data = IntervensiModel::find($id);
        return view("intervensi.modal-form", compact('mode', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $id = $request->id;
        $data = IntervensiModel::find($id);

        if(IntervensiModel::where('jenis','=',$request->jenis)->exists() && $request->jenis != $data->jenis){
            $response['status'] = "E";
            $response['msg'] = "Jenis intervensi sudah ada sebelumnya";

            return response()->json($response);
        }

        $data->update($request->except(["mode"]));

        $response['status'] = "S";
        $response['msg'] = "Data berhasil disimmpan";
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        IntervensiModel::destroy($id);
        echo json_encode("success");
    }
}

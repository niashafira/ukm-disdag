<?php

namespace App\Http\Controllers;

use App\Models\IntervensiModel;
use Illuminate\Http\Request;

class IntervensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_intervensi = IntervensiModel::get();
        return view('intervensi.index', compact('data_intervensi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mode = "create";
        return view("intervensi.modal-form", compact('mode'));
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

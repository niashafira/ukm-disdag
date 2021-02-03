<?php

namespace App\Http\Controllers;

use App\Models\UkmModel;
use Illuminate\Http\Request;

class UkmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_ukm = UkmModel::get();
        return view('ukm.index', compact('data_ukm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mode = "create";
        return view("ukm.modal-form", compact('mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        print_r($request->all());

        $nama_ukm = strtolower($request->nama_ukm);
        if(UkmModel::whereRaw('lower(nama_ukm) like (?)',["%{$nama_ukm}%"])->exists()){
            $response['status'] = "E";
            $response['msg'] = "Nama UKM sudah ada sebelumnya";

            return response()->json($response);
        }

        UkmModel::create($request->except(["mode"]));
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
        $data = UkmModel::find($id);
        return view("ukm.modal-form", compact('mode', 'data'));
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
        $data = UkmModel::find($id);

        $nama_ukm = strtolower($request->nama_ukm);

        if(UkmModel::whereRaw('lower(nama_ukm) like (?)',["%{$nama_ukm}%"])->exists() && $nama_ukm != strtolower($data->nama_ukm)){
            $response['status'] = "E";
            $response['msg'] = "Nama UKM sudah ada sebelumnya";

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
        UkmModel::destroy($id);
        echo json_encode("success");
    }
}

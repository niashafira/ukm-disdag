<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use Illuminate\Http\Request;

class UkmController extends Controller
{

    public function index()
    {
        $data_ukm = Ukm::get();
        return view('ukm.index', compact('data_ukm'));
    }

    public function create()
    {
        $mode = "create";
        return view("ukm.form", compact('mode'));
    }

    public function store(Request $request)
    {
        print_r($request->all());

        $nama_ukm = strtolower($request->nama_ukm);
        if(Ukm::whereRaw('lower(nama_ukm) like (?)',["%{$nama_ukm}%"])->exists()){
            $response['status'] = "E";
            $response['msg'] = "Nama UKM sudah ada sebelumnya";

            return response()->json($response);
        }

        Ukm::create($request->except(["mode"]));
        $response['status'] = "S";
        $response['msg'] = "Data berhasil disimmpan";
        return response()->json($response);
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

        $id = $request->id;
        $data = Ukm::find($id);

        $nama_ukm = strtolower($request->nama_ukm);

        if(Ukm::whereRaw('lower(nama_ukm) like (?)',["%{$nama_ukm}%"])->exists() && $nama_ukm != strtolower($data->nama_ukm)){
            $response['status'] = "E";
            $response['msg'] = "Nama UKM sudah ada sebelumnya";

            return response()->json($response);
        }

        $data->update($request->except(["mode"]));

        $response['status'] = "S";
        $response['msg'] = "Data berhasil disimmpan";
        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        Ukm::destroy($id);
        echo json_encode("success");
    }

    public function getAll(){
        $data_ukm = Ukm::get();

        return response()->json($data_ukm);
    }
}

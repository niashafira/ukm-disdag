<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function getByKcmId(Request $request){
        try{
            return response()->json([
                'status' => "S",
                'data' => Kelurahan::where('klh_kcm_id', '=', $request->input('kecamatanId'))->get()
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => "Gagal mendapatkan data"
            ]);
        }
    }
}

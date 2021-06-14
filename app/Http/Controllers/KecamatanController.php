<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Exception;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function getAll(){
        try{
            return response()->json([
                'status' => "S",
                'data' => Kecamatan::get()
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => "Gagal mendapatkan data"
            ]);
        }
    }
}

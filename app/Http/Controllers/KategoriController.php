<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function getAll(){
        try{
            return response()->json([
                'status' => "S",
                'data' => Kategori::get()
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => "Gagal mendapatkan data"
            ]);
        }
    }
}

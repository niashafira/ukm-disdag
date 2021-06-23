<?php

namespace App\Http\Controllers;

use App\Models\Ukm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FixingDataController extends Controller
{
    public function mappingKelurahan(){
        $match_ukm = [];

        try{
            DB::beginTransaction();

            $ukm = DB::select("
                SELECT id, nik, nama_usaha, nama_pemilik
                FROM ukm_disdag.ukm
            ");
            $ukm_elocal = DB::select("
                SELECT ukm_nik, ukm_klh_id, ukm_nama, ukm_pemilik
                FROM elocal.ukm
            ");

            for ($i=0; $i < count($ukm); $i++) {
                for ($j=0; $j < count($ukm_elocal); $j++) {
                    if ($ukm[$i]->nik == $ukm_elocal[$j]->ukm_nik && $ukm_elocal[$j]->ukm_klh_id != null) {
                        $res['ukm_disdag'] = $ukm[$i];
                        $res['elocal'] = $ukm_elocal[$j];
                        array_push($match_ukm, $res);

                        Ukm::where('id', $ukm[$i]->id)->update(array('kelurahan_id' => $ukm_elocal[$j]->ukm_klh_id));
                    }
                }
            }

            DB::commit();
            echo json_encode($match_ukm);
        } catch(Exception $e){
            DB::rollback();
            throw $e;
        }
    }
}

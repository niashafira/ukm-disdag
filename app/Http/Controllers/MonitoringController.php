<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('monitoring.index');
    }

    public function filter(Request $request)
    {
        $column = ["nama_intervensi", "deskripsi", "lokasi"];

        $sql = "SELECT * FROM ukm_disdag.intervensi";
        $sql_count = "SELECT COUNT(*) FROM ukm_disdag.intervensi";


        $limit = " LIMIT 10";
        $offset = " OFFSET " . $request->offset;
        $order_by = " ORDER BY tanggal_mulai DESC";

        $where = "";

        if(count($request->jenis_intervensi) != 0){
            $where = " WHERE (";
            for ($i=0; $i < count($request->jenis_intervensi); $i++) {
                if($i > 0 && $i != count($request->jenis_intervensi)){
                    $where .= " OR ";
                }
                $where .= "jenis_intervensi = '" . $request->jenis_intervensi[$i]["key"] . "'";

                if($i == count($request->jenis_intervensi) - 1){
                    $where .= ")";
                }
            }

            if($request->tanggal_mulai != ""){
                $where .= " AND (tanggal_mulai between '". $request->tanggal_mulai ."' AND '". $request->tanggal_selesai ."')";
            }

            if($request->kata_kunci != ""){
                $where .= " AND (";
                for ($i=0; $i < count($column); $i++) {

                    if($i > 0 && $i != count($column)){
                        $where .= " OR ";
                    }

                    $where .= "lower(". $column[$i] .") LIKE '%" . strtolower($request->kata_kunci) . "%'";

                    if($i == count($column) - 1){
                        $where .= ")";
                    }
                }
            }

            $query = $sql . $where . $order_by . $limit . $offset;
            $query_count = $sql_count . $where;

            $intervensi = DB::select($query);
            $intervensi_count = DB::select($query_count);

            $res["data"] = $intervensi;
            $res["count"] = $intervensi_count;
            $res["status"] = "S";

        }

        else{
            $res["data"] = [];
            $res["count"] = 0;
            $res["status"] = "S";
        }

        echo json_encode($res);
    }
}

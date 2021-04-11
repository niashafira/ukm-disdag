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

            if($request->halal['checked'] == true){

                $sql_halal = "SELECT a.tgl_permohonan, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
                from ukm_disdag.sertifikasi_halal AS a
                INNER JOIN ukm_disdag.ukm AS b
                ON b.id = a.ukm_id";

                $sql_count_halal = "SELECT COUNT(*) FROM ukm_disdag.sertifikasi_halal";

                $offset_halal = " OFFSET " . $request->halal['offset'];
                $order_by_halal = " ORDER BY tgl_permohonan DESC";
                $where_halal = "";
                if($request->tanggal_mulai != ""){
                    $where_halal .= " WHERE tgl_permohonan between '". $request->tanggal_mulai ."' AND '". $request->tanggal_selesai ."'";
                }

                $query_halal = $sql_halal . $where_halal . $order_by_halal . $limit . $offset_halal;
                $query_count_halal = $sql_count_halal . $where_halal;

                $sertifikasi_halal = DB::select($query_halal);
                $count_halal = DB::select($query_count_halal);

                $res["halal"] = $sertifikasi_halal;
                $res["count_halal"] = $count_halal;
            }
            else{
                $res["halal"] = [];
                $res["count_halal"] = 0;
            }

            if($request->merek['checked'] == true){
                $sql_merek = "SELECT a.no_permohonan, a.tgl_berkas_kemenkumham, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
                from ukm_disdag.sertifikasi_merek AS a
                INNER JOIN ukm_disdag.ukm AS b
                ON b.id = a.ukm_id";

                $sql_count_merek = "SELECT COUNT(*) FROM ukm_disdag.sertifikasi_merek";

                $offset_merek = " OFFSET " . $request->merek['offset'];
                $order_by_merek = " ORDER BY tgl_berkas_kemenkumham DESC";
                $where_merek = "";
                if($request->tanggal_mulai != ""){
                    $where_merek .= " WHERE tgl_berkas_kemenkumham between '". $request->tanggal_mulai ."' AND '". $request->tanggal_selesai ."'";
                }

                $query_merek = $sql_merek . $where_merek . $order_by_merek . $limit . $offset_merek;
                $query_count_merek = $sql_count_merek . $where_merek;

                $sertifikasi_merek = DB::select($query_merek);
                $count_merek = DB::select($query_count_merek);
                $res["merek"] = $sertifikasi_merek;
                $res["count_merek"] = $count_merek;

            }
            else{
                $res["merek"] = [];
                $res["count_merek"] = 0;
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
            $res["merek"] = [];
            $res["count_merek"] = 0;
            $res["halal"] = [];
            $res["count_halal"] = 0;
            $res["status"] = "S";
        }

        echo json_encode($res);
    }
}

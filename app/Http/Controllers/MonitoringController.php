<?php

namespace App\Http\Controllers;

use App\Models\Intervensi;
use App\Models\SertifikasiHalal;
use App\Models\SertifikasiMerek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

            if($request->pelatihan['checked'] == true){
                $sql_pelatihan = "SELECT * FROM ukm_disdag.intervensi WHERE jenis_intervensi = 'pelatihan' ";

                $sql_count_pelatihan = "SELECT COUNT(*) FROM ukm_disdag.intervensi WHERE jenis_intervensi = 'pelatihan' ";

                $offset_pelatihan = " OFFSET " . $request->pelatihan['offset'];
                $order_by_merek = " ORDER BY tanggal_mulai DESC";
                $where_pelatihan = "";
                if($request->tanggal_mulai != ""){
                    $where_pelatihan .= " AND tanggal_mulai between '". $request->tanggal_mulai ."' AND '". $request->tanggal_selesai ."' ";
                }

                if($request->kata_kunci != ""){
                    $where_pelatihan .= " AND (";
                    for ($i=0; $i < count($column); $i++) {

                        if($i > 0 && $i != count($column)){
                            $where_pelatihan .= " OR ";
                        }

                        $where_pelatihan .= "lower(". $column[$i] .") LIKE '%" . strtolower($request->kata_kunci) . "%'";

                        if($i == count($column) - 1){
                            $where_pelatihan .= ")";
                        }
                    }
                }

                $query_pelatihan = $sql_pelatihan . $where_pelatihan . $order_by_merek . $limit . $offset_pelatihan;
                $query_count_pelatihan = $sql_count_pelatihan . $where_pelatihan;

                $pelatihan = DB::select($query_pelatihan);
                $count_pelatihan = DB::select($query_count_pelatihan);
                $res["pelatihan"] = $pelatihan;
                $res["count_pelatihan"] = $count_pelatihan;

            }
            else{
                $res["pelatihan"] = [];
                $res["count_pelatihan"] = 0;
            }

            if($request->pemasaran['checked'] == true){
                $sql_pemasaran = "SELECT * FROM ukm_disdag.intervensi WHERE jenis_intervensi = 'pemasaran' ";

                $sql_count_pemasaran = "SELECT COUNT(*) FROM ukm_disdag.intervensi WHERE jenis_intervensi = 'pemasaran' ";

                $offset_pemasaran = " OFFSET " . $request->pemasaran['offset'];
                $order_by_merek = " ORDER BY tanggal_mulai DESC";
                $where_pemasaran = "";
                if($request->tanggal_mulai != ""){
                    $where_pemasaran .= " AND tanggal_mulai between '". $request->tanggal_mulai ."' AND '". $request->tanggal_selesai ."' ";
                }

                if($request->kata_kunci != ""){
                    $where_pemasaran .= " AND (";
                    for ($i=0; $i < count($column); $i++) {

                        if($i > 0 && $i != count($column)){
                            $where_pemasaran .= " OR ";
                        }

                        $where_pemasaran .= "lower(". $column[$i] .") LIKE '%" . strtolower($request->kata_kunci) . "%'";

                        if($i == count($column) - 1){
                            $where_pemasaran .= ")";
                        }
                    }
                }

                $query_pemasaran = $sql_pemasaran . $where_pemasaran . $order_by_merek . $limit . $offset_pemasaran;
                $query_count_pemasaran = $sql_count_pemasaran . $where_pemasaran;

                $pemasaran = DB::select($query_pemasaran);
                $count_pemasaran = DB::select($query_count_pemasaran);
                $res["pemasaran"] = $pemasaran;
                $res["count_pemasaran"] = $count_pemasaran;

            }
            else{
                $res["pemasaran"] = [];
                $res["count_pemasaran"] = 0;
            }

            if($request->pameran['checked'] == true){
                $sql_pameran = "SELECT * FROM ukm_disdag.intervensi WHERE jenis_intervensi = 'pameran' ";

                $sql_count_pameran = "SELECT COUNT(*) FROM ukm_disdag.intervensi WHERE jenis_intervensi = 'pameran' ";

                $offset_pameran = " OFFSET " . $request->pameran['offset'];
                $order_by_merek = " ORDER BY tanggal_mulai DESC";
                $where_pameran = "";
                if($request->tanggal_mulai != ""){
                    $where_pameran .= " AND tanggal_mulai between '". $request->tanggal_mulai ."' AND '". $request->tanggal_selesai ."' ";
                }

                if($request->kata_kunci != ""){
                    $where_pameran .= " AND (";
                    for ($i=0; $i < count($column); $i++) {

                        if($i > 0 && $i != count($column)){
                            $where_pameran .= " OR ";
                        }

                        $where_pameran .= "lower(". $column[$i] .") LIKE '%" . strtolower($request->kata_kunci) . "%'";

                        if($i == count($column) - 1){
                            $where_pameran .= ")";
                        }
                    }
                }

                $query_pameran = $sql_pameran . $where_pameran . $order_by_merek . $limit . $offset_pameran;
                $query_count_pameran = $sql_count_pameran . $where_pameran;

                $pameran = DB::select($query_pameran);
                $count_pameran = DB::select($query_count_pameran);
                $res["pameran"] = $pameran;
                $res["count_pameran"] = $count_pameran;

            }
            else{
                $res["pameran"] = [];
                $res["count_pameran"] = 0;
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

    public function exportExcel(Request $request){
        if($request->halal['checked'] == true){
            $result['halal'] = $this->getHalal($request['tanggal_mulai'], $request['tanggal_selesai']);
        }
        if($request->merek['checked'] == true){
            $result['merek'] = $this->getMerek($request['tanggal_mulai'], $request['tanggal_selesai']);
        }
        if($request->pelatihan['checked'] == true){
            $result['pelatihan'] = $this->getPelatihan($request['tanggal_mulai'], $request['tanggal_selesai']);
        }
        if($request->pameran['checked'] == true){
            $result['pameran'] = $this->getPameran($request['tanggal_mulai'], $request['tanggal_selesai']);
        }
        if($request->pemasaran['checked'] == true){
            $result['pemasaran'] = $this->getPemasaran();
        }

        return $this->setExcel($result, $request['tanggal_mulai'], $request['tanggal_selesai']);

        // return response()->json($result);
    }

    public function getHalal($tanggal_mulai, $tanggal_selesai){
        return DB::select("
            SELECT a.tgl_permohonan, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
            from ukm_disdag.sertifikasi_halal AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id
            WHERE a.tgl_permohonan between '" . $tanggal_mulai . "' and '" . $tanggal_selesai . "'
            ORDER BY a.tgl_permohonan DESC"
        );
    }

    public function getMerek($tanggal_mulai, $tanggal_selesai){
        return DB::select("
            SELECT a.nama_merek, a.no_permohonan, a.tgl_berkas_kemenkumham, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
            from ukm_disdag.sertifikasi_merek AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id
            WHERE a.tgl_berkas_kemenkumham between '" . $tanggal_mulai . "' and '" . $tanggal_selesai . "'
            ORDER BY a.tgl_berkas_kemenkumham DESC"
        );
    }

    public function getPelatihan($tanggal_mulai, $tanggal_selesai){
        return Intervensi::whereBetween('tanggal_mulai', [$tanggal_mulai, $tanggal_selesai])
        ->where('jenis_intervensi', '=', 'pelatihan')
        ->orderBy('tanggal_mulai', 'DESC')
        ->get();
    }

    public function getPameran($tanggal_mulai, $tanggal_selesai){
        return Intervensi::whereBetween('tanggal_mulai', [$tanggal_mulai, $tanggal_selesai])
        ->where('jenis_intervensi', '=', 'pameran')
        ->orderBy('tanggal_mulai', 'DESC')
        ->get();
    }

    public function getPemasaran(){
        return Intervensi::where('jenis_intervensi', '=', 'pemasaran')
        ->get();
    }

    public function setExcel($result, $tgl_mulai, $tgl_selesai){
        $spreadsheet = new Spreadsheet();
        $activeSheet = 0;

        //PELATIHAN
        if(isset($result['pelatihan'])){
            $spreadsheet->createSheet();
            $activeSheet++;
            $spreadsheet->setActiveSheetIndex($activeSheet);
            $spreadsheet->getActiveSheet()->setTitle('Pelatihan');
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);

            $sheet->setCellValue('A1', "No");
            $sheet->setCellValue('B1', "Nama Pelatihan");
            $sheet->setCellValue('C1', "Tanggal Mulai");
            $sheet->setCellValue('D1', "Tanggal Selesai");
            $sheet->setCellValue('E1', "Lokasi");
            $sheet->setCellValue('F1', "Deskripsi");
            $sheet->getStyle('A1:F1')->applyFromArray($this->styleExcel("header"));

            $col_num = 2;
            for ($i=0; $i < count($result['pelatihan']); $i++) {
                $sheet->setCellValue('A'.$col_num, $i + 1);
                $sheet->setCellValue('B'.$col_num, $result['pelatihan'][$i]['nama_intervensi']);
                $sheet->setCellValue('C'.$col_num, date('d F Y', strtotime($result['pelatihan'][$i]['tanggal_mulai'])));
                $sheet->setCellValue('D'.$col_num, date('d F Y', strtotime($result['pelatihan'][$i]['tanggal_selesai'])));
                $sheet->setCellValue('E'.$col_num, $result['pelatihan'][$i]['lokasi']);
                $sheet->setCellValue('F'.$col_num, $result['pelatihan'][$i]['deskripsi']);
                $col_num++;
            }
            $sheet->getStyle('A1:F'.($col_num-1))->applyFromArray($this->styleExcel("all_border"));
            $spreadsheet->getActiveSheet()->getStyle('A2:F'.($col_num-1))->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A2:A'.($col_num-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('B1:F'.($col_num-1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }


        //PAMERAN
        if(isset($result['pameran'])){
            $spreadsheet->createSheet();
            $activeSheet++;
            $spreadsheet->setActiveSheetIndex($activeSheet);
            $spreadsheet->getActiveSheet()->setTitle('Bazar&Pameran');
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);

            $sheet->setCellValue('A1', "No");
            $sheet->setCellValue('B1', "Nama Pameran");
            $sheet->setCellValue('C1', "Tanggal Mulai");
            $sheet->setCellValue('D1', "Tanggal Selesai");
            $sheet->setCellValue('E1', "Lokasi");
            $sheet->setCellValue('F1', "Deskripsi");
            $sheet->getStyle('A1:F1')->applyFromArray($this->styleExcel("header"));

            $col_num = 2;
            for ($i=0; $i < count($result['pameran']); $i++) {
                $sheet->setCellValue('A'.$col_num, $i + 1);
                $sheet->setCellValue('B'.$col_num, $result['pameran'][$i]['nama_intervensi']);
                $sheet->setCellValue('C'.$col_num, date('d F Y', strtotime($result['pameran'][$i]['tanggal_mulai'])));
                $sheet->setCellValue('D'.$col_num, date('d F Y', strtotime($result['pameran'][$i]['tanggal_selesai'])));
                $sheet->setCellValue('E'.$col_num, $result['pameran'][$i]['lokasi']);
                $sheet->setCellValue('F'.$col_num, $result['pameran'][$i]['deskripsi']);
                $col_num++;
            }
            $sheet->getStyle('A1:F'.($col_num-1))->applyFromArray($this->styleExcel("all_border"));
            $spreadsheet->getActiveSheet()->getStyle('A2:F'.($col_num-1))->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A2:A'.($col_num-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('B1:F'.($col_num-1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }


        //PEMASARAN
        if(isset($result['pemasaran'])){
            $spreadsheet->createSheet();
            $activeSheet++;
            $spreadsheet->setActiveSheetIndex($activeSheet);
            $spreadsheet->getActiveSheet()->setTitle('Pemasaran');
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);

            $sheet->setCellValue('A1', "No");
            $sheet->setCellValue('B1', "Nama Pemasaran");
            $sheet->setCellValue('C1', "Lokasi");
            $sheet->setCellValue('D1', "Deskripsi");
            $sheet->getStyle('A1:D1')->applyFromArray($this->styleExcel("header"));

            $col_num = 2;
            for ($i=0; $i < count($result['pameran']); $i++) {
                $sheet->setCellValue('A'.$col_num, $i + 1);
                $sheet->setCellValue('B'.$col_num, $result['pameran'][$i]['nama_intervensi']);
                $sheet->setCellValue('C'.$col_num, $result['pameran'][$i]['lokasi']);
                $sheet->setCellValue('D'.$col_num, $result['pameran'][$i]['deskripsi']);
                $col_num++;
            }
            $sheet->getStyle('A1:D'.($col_num-1))->applyFromArray($this->styleExcel("all_border"));
            $spreadsheet->getActiveSheet()->getStyle('A2:D'.($col_num-1))->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A2:A'.($col_num-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('B1:D'.($col_num-1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }


        //SERTIFIKASI HALAL
        if(isset($result['halal'])){
            $spreadsheet->createSheet();
            $activeSheet++;
            $spreadsheet->setActiveSheetIndex($activeSheet);
            $spreadsheet->getActiveSheet()->setTitle('Sertifikasi Halal');
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(30);

            $sheet->setCellValue('A1', "No");
            $sheet->setCellValue('B1', "Nama UKM");
            $sheet->setCellValue('C1', "Tanggal Permohonan");
            $sheet->setCellValue('D1', "Status");
            $sheet->setCellValue('E1', "No Sertifikat");
            $sheet->setCellValue('F1', "Tanggal Sertifikat");
            $sheet->setCellValue('G1', "Keterangan");
            $sheet->getStyle('A1:G1')->applyFromArray($this->styleExcel("header"));

            $col_num = 2;
            for ($i=0; $i < count($result['halal']); $i++) {
                $sheet->setCellValue('A'.$col_num, $i + 1);
                $sheet->setCellValue('B'.$col_num, $result['halal'][$i]->nama_usaha);
                $sheet->setCellValue('C'.$col_num, date('d F Y', strtotime($result['halal'][$i]->tgl_permohonan)));
                $sheet->setCellValue('D'.$col_num, $this->getStatusSertifikat($result['halal'][$i]->status));
                $sheet->setCellValue('E'.$col_num, $result['halal'][$i]->no_sertifikat);
                $sheet->setCellValue('F'.$col_num, date('d F Y', strtotime($result['halal'][$i]->tgl_sertifikat)));
                $sheet->setCellValue('G'.$col_num, $result['halal'][$i]->keterangan);
                $col_num++;
            }
            $sheet->getStyle('A1:G'.($col_num-1))->applyFromArray($this->styleExcel("all_border"));
            $spreadsheet->getActiveSheet()->getStyle('A2:G'.($col_num-1))->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A2:A'.($col_num-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('B1:G'.($col_num-1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }

        //SERTIFIKASI MEREK
        if(isset($result['halal'])){
            $spreadsheet->createSheet();
            $activeSheet++;
            $spreadsheet->setActiveSheetIndex($activeSheet);
            $spreadsheet->getActiveSheet()->setTitle('Sertifikasi Merek');
            $sheet = $spreadsheet->getActiveSheet();

            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(30);

            $sheet->setCellValue('A1', "No");
            $sheet->setCellValue('B1', "Nama UKM");
            $sheet->setCellValue('C1', "Tanggal Permohonan");
            $sheet->setCellValue('D1', "Status");
            $sheet->setCellValue('E1', "No Sertifikat");
            $sheet->setCellValue('F1', "Tanggal Sertifikat");
            $sheet->setCellValue('G1', "Keterangan");
            $sheet->getStyle('A1:G1')->applyFromArray($this->styleExcel("header"));

            $col_num = 2;
            for ($i=0; $i < count($result['merek']); $i++) {
                $sheet->setCellValue('A'.$col_num, $i + 1);
                $sheet->setCellValue('B'.$col_num, $result['merek'][$i]->nama_usaha);
                $sheet->setCellValue('C'.$col_num, date('d F Y', strtotime($result['merek'][$i]->tgl_berkas_kemenkumham)));
                $sheet->setCellValue('D'.$col_num, $this->getStatusSertifikat($result['merek'][$i]->status));
                $sheet->setCellValue('E'.$col_num, $result['merek'][$i]->no_sertifikat);
                if($result['merek'][$i]->tgl_sertifikat){
                    $sheet->setCellValue('F'.$col_num, date('d F Y', strtotime($result['merek'][$i]->tgl_sertifikat)));
                }
                $sheet->setCellValue('G'.$col_num, $result['merek'][$i]->keterangan);
                $col_num++;
            }
            $sheet->getStyle('A1:G'.($col_num-1))->applyFromArray($this->styleExcel("all_border"));
            $spreadsheet->getActiveSheet()->getStyle('A2:G'.($col_num-1))->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A2:A'.($col_num-1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('B1:G'.($col_num-1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        }

        //SUMMARY
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setTitle('Summary');
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $sheet->setCellValue('A1', "Jenis Intervensi");
        $sheet->setCellValue('B1', "Tanggal");
        $sheet->setCellValue('C1', "Jumlah");
        $sheet->getStyle('A1:C1')->applyFromArray($this->styleExcel("header"));

        $num_col_intervensi = 2;

        if(isset($result['pelatihan'])){
            $sheet->setCellValue('A'.$num_col_intervensi, "Pelatihan");
            $sheet->setCellValue('B'.$num_col_intervensi, date('d F Y', strtotime($tgl_mulai)) . " - " . date('d F Y', strtotime($tgl_selesai)));
            $sheet->setCellValue('C'.$num_col_intervensi, count($result['pelatihan']));
            $num_col_intervensi++;
        }

        if(isset($result['pameran'])){
            $sheet->setCellValue('A'.$num_col_intervensi, "Pameran");
            $sheet->setCellValue('B'.$num_col_intervensi, date('d F Y', strtotime($tgl_mulai)) . " - " . date('d F Y', strtotime($tgl_selesai)));
            $sheet->setCellValue('C'.$num_col_intervensi, count($result['pameran']));
            $num_col_intervensi++;
        }

        if(isset($result['pemasaran'])){
            $sheet->setCellValue('A'.$num_col_intervensi, "Pemasaran");
            $sheet->setCellValue('B'.$num_col_intervensi, date('d F Y', strtotime($tgl_mulai)) . " - " . date('d F Y', strtotime($tgl_selesai)));
            $sheet->setCellValue('C'.$num_col_intervensi, count($result['pemasaran']));
            $num_col_intervensi++;
        }

        if(isset($result['halal'])){
            $sheet->setCellValue('A'.$num_col_intervensi, "Sertifikasi Halal");
            $sheet->setCellValue('B'.$num_col_intervensi, date('d F Y', strtotime($tgl_mulai)) . " - " . date('d F Y', strtotime($tgl_selesai)));
            $sheet->setCellValue('C'.$num_col_intervensi, count($result['halal']));
            $num_col_intervensi++;
        }

        if(isset($result['merek'])){
            $sheet->setCellValue('A'.$num_col_intervensi, "Sertifikasi Merek");
            $sheet->setCellValue('B'.$num_col_intervensi, date('d F Y', strtotime($tgl_mulai)) . " - " . date('d F Y', strtotime($tgl_selesai)));
            $sheet->setCellValue('C'.$num_col_intervensi, count($result['merek']));
            $num_col_intervensi++;
        }

        $sheet->getStyle('A1:C'.($num_col_intervensi-1))->applyFromArray($this->styleExcel("all_border"));

        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();

        return "data:application/vnd.ms-excel;base64,".base64_encode($xlsData);
    }

    function getStatusSertifikat($sertifikat){
        if($sertifikat == "sudah_keluar_sertifikat"){
            return "Sudah Keluar Sertifikat";
        }
        else if($sertifikat == "ditolak"){
            return "Ditolak";
        }
        else if($sertifikat == "menunggu_tanggapan"){
            return "Menunggu Tanggapan";
        }
        else if($sertifikat == "proses_cetak"){
            return "Proses Cetak";
        }
    }

    function styleExcel($type){
        if($type == "all_border"){
            return [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];
        }

        else if($type == "header"){
            return [
                'font' => [
                    'bold' => true,
                    'color' => 	array('rgb' => 'FFFFFF')
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => '663259',
                    ]
                ],
            ];
        }

    }
}

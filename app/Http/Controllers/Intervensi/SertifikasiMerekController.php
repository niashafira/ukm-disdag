<?php

namespace App\Http\Controllers\Intervensi;

use App\Http\Controllers\Controller;
use App\Models\IntervensiDetail;
use App\Models\SertifikasiMerek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;
use DataTables;

class SertifikasiMerekController extends Controller
{
    public function index()
    {
        $intervensi = DB::select("
            SELECT a.nama_merek, a.no_permohonan, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
            from ukm_disdag.sertifikasi_merek AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id;
        ");

        return view('intervensi.merek.index', compact('intervensi'));
    }

    public function create()
    {
        $intervensi = "";
        $mode = "create";
        return view('intervensi.merek.form', compact('mode','intervensi'));
    }

    public function edit($id)
    {
        $intervensi = DB::select("
        SELECT a.nama_merek, a.no_permohonan, a.tgl_berkas_kemenkumham, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
            from ukm_disdag.sertifikasi_merek AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id
            WHERE a.id = " . $id . ";
        ");

        $mode = "edit";
        return view('intervensi.merek.form', compact('mode', 'intervensi'));
    }

    public function store(Request $request)
    {
        $sertifikasi_merek = $request->intervensi_detail;
        unset($sertifikasi_merek['nama_usaha']);
        SertifikasiMerek::create($sertifikasi_merek);

        echo json_encode("sukses");
    }

    public function update(Request $request)
    {
        $input = $request->intervensi_detail;
        $intervensi = SertifikasiMerek::find($input['id']);
        unset($input['nama_usaha']);
        $intervensi->update($input);

        echo json_encode("sukses");
    }

    public function getListDT(Request $request){
        $data = DB::select("
        SELECT a.nama_merek, a.no_permohonan, a.tgl_berkas_kemenkumham, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
        from ukm_disdag.sertifikasi_merek AS a
        INNER JOIN ukm_disdag.ukm AS b
        ON b.id = a.ukm_id
        WHERE a.tgl_berkas_kemenkumham between '{$request->input('tanggalMulai')}' AND '{$request->input('tanggalSelesai')}'
        ORDER BY a.tgl_berkas_kemenkumham DESC"
    );

        return Datatables::of($data)->make(true);
    }
}

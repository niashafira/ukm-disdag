<?php

namespace App\Http\Controllers\Intervensi;

use App\Http\Controllers\Controller;
use App\Models\Intervensi;
use App\Models\IntervensiDetail;
use App\Models\SertifikasiHalal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;
use DataTables;

class SertifikasiHalalController extends Controller
{
    public function index()
    {
        $intervensi = DB::select("
            SELECT a.tgl_permohonan, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
            from ukm_disdag.sertifikasi_halal AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id;
        ");

        return view('intervensi.halal.index', compact('intervensi'));
    }

    public function create()
    {
        $intervensi = "";
        $mode = "create";
        return view('intervensi.halal.form', compact('mode','intervensi'));
    }

    public function edit($id)
    {
        $intervensi = DB::select("
            SELECT a.tgl_permohonan, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
            from ukm_disdag.sertifikasi_halal AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id
            WHERE a.id = " . $id . ";
        ");

        $mode = "edit";
        return view('intervensi.halal.form', compact('mode', 'intervensi'));
    }

    public function store(Request $request)
    {
        $intervensi_detail = $request->intervensi_detail;
        unset($intervensi_detail['nama_usaha']);
        SertifikasiHalal::create($intervensi_detail);

        echo json_encode("sukses");
    }

    public function update(Request $request)
    {
        $input = $request->intervensi_detail;
        $intervensi = SertifikasiHalal::find($input['id']);
        unset($input['nama_usaha']);
        $intervensi->update($input);

        echo json_encode("sukses");
    }

    public function getListDT(Request $request){
        $data = DB::select("
            SELECT a.tgl_permohonan, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
            from ukm_disdag.sertifikasi_halal AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id
            WHERE a.tgl_permohonan between '" . $request->input('tanggalMulai') . "' and '" . $request->input('tanggalSelesai') . "'
            ORDER BY a.tgl_permohonan DESC"
        );

        return Datatables::of($data)->make(true);
    }
}

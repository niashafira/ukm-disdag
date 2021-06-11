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
        ")[0];

        $mode = "edit";
        return view('intervensi.halal.form', compact('mode', 'intervensi'));
    }

    public function store(Request $request)
    {
        try{
            SertifikasiHalal::create($request->intervensi);

            return response()->json([
                'status' => "S",
                'message' => "Data berhasil disimpan"
            ]);

        } catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => "Data gagal disimpan"
            ]);
        }
    }

    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $intervensi = SertifikasiHalal::find($request->intervensi['id']);
            $intervensi->update($request->intervensi);
            DB::commit();

            return response()->json([
                'status' => "S",
                'message' => "Data berhasil disimpan"
            ]);

        } catch(Exception $e){
            DB::rollBack();
            return response()->json([
                'status' => "E",
                'message' => "Data gagal disimpan"
            ]);
        }
    }

    public function getHalalDT(Request $request){
        try{
            $data = DB::select("
                SELECT a.tgl_permohonan, a.status, a.no_sertifikat, a.tgl_sertifikat, a.keterangan, a.id, b.nama_usaha
                from ukm_disdag.sertifikasi_halal AS a
                INNER JOIN ukm_disdag.ukm AS b
                ON b.id = a.ukm_id
                ORDER BY a.tgl_permohonan DESC"
            );

            return Datatables::of($data)->make(true);

        }catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => $e->getMessage()
            ], 500);
        }
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

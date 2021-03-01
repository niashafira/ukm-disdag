<?php

namespace App\Http\Controllers\Intervensi;

use App\Http\Controllers\Controller;
use DB;
use App\Models\Intervensi;
use App\Models\IntervensiDetail;
use Illuminate\Http\Request;

class SertifikatHalalController extends Controller
{
    public function index()
    {
        $intervensi = DB::select("
            SELECT a.id, a.ukm_id, a.intervensi_id, a.keterangan, b.nama_usaha, a.tanggal, a.no_permohonan
            from ukm_disdag.intervensi_detail AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id
            WHERE a.intervensi_id = 23;
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
            SELECT a.id, a.ukm_id, a.intervensi_id, a.keterangan, b.nama_usaha, a.tanggal, a.no_permohonan
            from ukm_disdag.intervensi_detail AS a
            INNER JOIN ukm_disdag.ukm AS b
            ON b.id = a.ukm_id
            WHERE a.intervensi_id = 23 AND a.id = " . $id . ";
        ");

        $mode = "edit";
        return view('intervensi.halal.form', compact('mode', 'intervensi'));
    }

    public function store(Request $request)
    {
        $intervensi_detail = $request->intervensi_detail;
        unset($intervensi_detail['nama_usaha']);
        IntervensiDetail::create($intervensi_detail);

        echo json_encode("sukses");
    }

    public function update(Request $request)
    {
        $input = $request->intervensi_detail;
        $intervensi = IntervensiDetail::find($input['id']);
        unset($input['nama_usaha']);
        $intervensi->update($input);

        echo json_encode("sukses");
    }
}

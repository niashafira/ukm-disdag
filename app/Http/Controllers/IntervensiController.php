<?php

namespace App\Http\Controllers;

use App\Models\Intervensi;
use App\Models\IntervensiDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;
use DataTables;

class IntervensiController extends Controller
{
    public function getIntervensiDT(Request $request){
        try{
            $data = Intervensi::where("jenis_intervensi", "=", $request->input('jenisIntervensi'));

            return Datatables::of($data)->make(true);

        }catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getIntervensiDetail(Request $request){
        try{
            $data = DB::select("
                SELECT a.id, a.ukm_id, a.intervensi_id, b.nama_usaha, b.nama_pemilik, b.nik, b.alamat
                from ukm_disdag.intervensi_detail AS a
                JOIN ukm_disdag.ukm AS b
                ON b.id = a.ukm_id
                WHERE a.intervensi_id = {$request->input('intervensiId')}
                ORDER BY b.nama_usaha ASC"
            );

            return response()->json([
                'status' => "S",
                'message' => "Berhasil",
                'data' => $data
            ], 200);

        } catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request){
        try{
            DB::beginTransaction();

            if(count($request->intervensiDetail) == 0){
                return response()->json([
                    'status' => "E",
                    'message' => "Peserta tidak boleh kosong"
                ]);
            }

            $intervensi = Intervensi::create($request->intervensi);

            foreach ($request->intervensiDetail as $detail) {
                IntervensiDetail::create([
                    'intervensi_id' => $intervensi->id,
                    'ukm_id' => $detail['ukm_id'],
                    'keterangan' => $detail['keterangan']
                ]);
            }

            DB::commit();

            return response()->json([
                'status' => "S",
                'message' => "Data berhasil disimpan"
            ]);


        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => "E",
                'message' => "Data gagal disimpan"
            ]);
        }
    }
}

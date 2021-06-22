<?php

namespace App\Http\Controllers;

use App\Models\IntervensiDetail;
use App\Models\Kategori;
use App\Models\KategoriDetail;
use App\Models\Omset;
use App\Models\SertifikasiHalal;
use App\Models\SertifikasiMerek;
use App\Models\Ukm;
use App\Models\UkmTidakTerdaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \stdClass;
use DataTables;
use Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class UkmController extends Controller
{

    public function index()
    {
        $ukm = Ukm::get();
        return view('ukm.index', compact('ukm'));
    }

    public function tidakTerdaftar()
    {
        return view('ukm.tidakTerdaftar.index');
    }

    public function create()
    {
        $mode = "create";
        return view("ukm.form", compact('mode'));
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $ukm = Ukm::create($request->ukm);
            $id = $ukm->id;

            if(isset($request->kategoriDetail)){
                foreach($request->kategoriDetail as $kategori){
                    $kategori['ukm_id'] = $id;
                    KategoriDetail::create($kategori);
                }
            }

            DB::commit();

            return response()->json([
                'status' => "S",
                'data' => $ukm,
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

    public function sinkronUkm(Request $request){
        try{
            DB::beginTransaction();

            if(isset($request->ukm)){
                $ukm = Ukm::create($request->ukm);
                $ukm_id = $ukm->id;
            }
            else{
                $ukm_id = $request->ukm_id;
            }

            IntervensiDetail::create([
                'ukm_id' => $ukm_id,
                'intervensi_id' => $request->intervensi_id
            ]);

            UkmTidakTerdaftar::destroy($request->ukmTidakTerdaftar_id);

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

    public function show($id)
    {
        try{
            $data['profil'] = DB::select("
                SELECT a.*, b.klh_nama AS nama_kelurahan, c.kcm_nama AS nama_kecamatan
                FROM ukm_disdag.ukm AS a
                LEFT JOIN ukm_disdag.kelurahan AS b on a.kelurahan_id = b.klh_id
                LEFT JOIN ukm_disdag.kecamatan AS c on b.klh_kcm_id = c.kcm_id
                WHERE a.id ={$id}
            ")[0];

            $data['intervensi'] =  DB::select("
                SELECT a.* from ukm_disdag.intervensi a
                JOIN ukm_disdag.intervensi_detail b
                ON a.id = b.intervensi_id
                WHERE b.ukm_id ={$id}"
            );

            $data['kategori'] =  DB::select("
                SELECT a.nama
                FROM ukm_disdag.kategori as a
                JOIN ukm_disdag.kategori_detail as b
                ON a.id = b.kategori_id
                WHERE b.ukm_id ={$id}
            ");

            return view("ukm.view", compact('data'));

        } catch(Exception $e){
            throw $e;
        }
    }

    public function storeOmset(Request $request){
        try{
            if (Omset::where('tanggal', '=', $request->omset['tanggal'])->exists()) {
                return response()->json([
                    'status' => "E",
                    'message' => "Omset pada {$request->omset['tanggal']} sudah ada"
                ]);
             }

            Omset::create($request->omset);

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

    public function exportUkmTanpaNik(){
        try{

            $data = DB::select("select * from ukm_disdag.ukm where nama_usaha is null");

            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', "No");
            $sheet->setCellValue('B1', "Nama UKM");
            $sheet->setCellValue('C1', "Nama Pemilik");
            $sheet->setCellValue('D1', "NIK");
            $sheet->setCellValue('E1', "Alamat");
            $sheet->setCellValue('F1', "Telepon");

            $i = 2;
            $no = 1;
            foreach ($data as $ukm) {
                $sheet->setCellValue('A'.$i, $no);
                $sheet->setCellValue('B'.$i, $ukm->nama_usaha);
                $sheet->setCellValue('C'.$i, $ukm->nama_pemilik);
                $sheet->setCellValue('D'.$i, "'" . $ukm->nik);
                $sheet->setCellValue('E'.$i, $ukm->alamat);
                $sheet->setCellValue('F'.$i, $ukm->no_telp);

                $i++;
                $no++;
            }

           $filename = "UKM_tanpa_nama.xlsx";
           $writer = new Xlsx($spreadsheet);
           header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
           header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');
           $writer->save('php://output');

        } catch(Exception $e){
            throw $e;
        }
    }

    public function getUkmTidakTerdaftar(){
        try{
            $data = DB::select("
                SELECT a.*, b.nama_intervensi, b.id as intervensi_id
                FROM ukm_disdag.ukm_tidak_terdaftar AS a
                JOIN intervensi as b
                ON a.intervensi_id = b.id
            ");

            return Datatables::of($data)->make(true);
        } catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateOmset(Request $request){
        try{
            $omset = Omset::find($request->omset['id']);
            $omset->update($request->omset);

            return response()->json([
                'status' => "S",
                'message' => "Data berhasil diupdate"
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => "Gagal update data"
            ]);
        }
    }

    public function deleteOmset($id){
        try{
            Omset::destroy($id);

            return response()->json([
                'status' => "S",
                'message' => "Data berhasil dihapus"
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => "E",
                'message' => "Hapus data gagal"
            ]);
        }
    }

    public function getOmset($id){
        return response()->json([
            'status' => "S",
            'data' => Omset::where('ukm_id', '=', $id)->orderBy('tanggal', 'DESC')->get()
        ]);
    }

    public function getSertifikasi($id){
        $halal = SertifikasiHalal::where('ukm_id', '=', $id)->get();
        $merek = SertifikasiMerek::where('ukm_id', '=', $id)->get();

        $sertifikasi['halal'] = $halal;
        $sertifikasi['merek'] = $merek;

        $res['status'] = "S";
        $res['data'] = $sertifikasi;
        echo json_encode($res);
    }

    public function edit($id)
    {
        $data['profil'] = DB::select("
                SELECT a.*, b.klh_nama AS nama_kelurahan, c.kcm_nama AS nama_kecamatan, b.klh_kcm_id AS kecamatan_id
                FROM ukm_disdag.ukm AS a
                LEFT JOIN ukm_disdag.kelurahan AS b on a.kelurahan_id = b.klh_id
                LEFT JOIN ukm_disdag.kecamatan AS c on b.klh_kcm_id = c.kcm_id
                WHERE a.id ={$id}
            ")[0];

        $data['kategori'] =  DB::select("
            SELECT a.nama
            FROM ukm_disdag.kategori as a
            JOIN ukm_disdag.kategori_detail as b
            ON a.id = b.kategori_id
            WHERE b.ukm_id ={$id}
        ");

        $mode = "edit";
        return view("ukm.form", compact('mode', 'data'));
    }

    public function update(Request $request)
    {
        try{
            DB::beginTransaction();

            $ukm = Ukm::find($request->ukm['id']);
            $ukm->update($request->ukm);
            KategoriDetail::where('ukm_id', '=', $request->ukm['id'])->delete();
            if(isset($request->kategoriDetail)){
                foreach($request->kategoriDetail as $kategori){
                    $kategori['ukm_id'] = $request->ukm['id'];
                    KategoriDetail::create($kategori);
                }
            }

            DB::commit();

            return response()->json([
                'status' => "S",
                'data' => $ukm,
                'message' => "Data berhasil disimpan"
            ]);

        } catch(Exception $e){
            DB::rollback();
            return response()->json([
                'status' => "E",
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {

    }

    public function checkDuplicateByNik(Request $request){
        $data = Ukm::where('nik', '=', $request->nik)->get();
        if($data === null){
            return response()->json([
                'status' => 'S',
                'state' => 'NIK belum pernah digunakan'
            ]);
        }
        else{
            return response()->json([
                'status' => 'E',
                'msg' => 'NIK sudah pernah digunakan',
                'data' => $data
            ]);
        }

    }

    //Cek duplicate ukm berdasarkan nama ukm dan nama pemilik
    public function checkDuplicateByNama(){
        $ukm_duplicate = [];
        $ukm_duplicate_count = 0;

        $data_ukm = Ukm::all();

        try{
            $temp = [];
            for ($i=0; $i < count($data_ukm); $i++) {
                $isDuplicate = false;
                for ($j=0; $j < count($temp); $j++) {
                    if($data_ukm[$i]['nama_usaha'] == $temp[$j]['nama_usaha'] && $data_ukm[$i]['nama_pemilik'] == $temp[$j]['nama_pemilik']){
                        $isDuplicate = true;
                        $ukm_duplicate_count++;
                        array_push($ukm_duplicate, $data_ukm[$i]);
                    }
                }
                if($isDuplicate == false){
                    array_push($temp, $data_ukm[$i]);
                }
            }

            return response()->json([
                'ukm_duplicate' => $ukm_duplicate,
                'ukm_duplicate_count' => $ukm_duplicate_count
            ], 500);

        } catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getAll(){
        try{
            $data = Ukm::all();

            return Datatables::of($data)->make(true);
        } catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function importNewData(){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path() . "/fix/ukm.xlsx");
        $spreadsheet->setActiveSheetIndex(0);

        $dataArray = $spreadsheet->getActiveSheet()->rangeToArray('B6:N1262',NULL,TRUE,TRUE,TRUE);

        foreach ($dataArray as $source) {
            $temp['nama_usaha'] = $source['B'];
            $temp['nama_pemilik'] = $source['C'];
            $temp['nik'] = preg_replace( '/^((?=^)(\s*))|((\s*)(?>$))/si', '', $source['D']);
            $temp['no_siup'] = $source['E'];
            $temp['alamat'] = $source['F'];
            $temp['kecamatan'] = preg_replace( '/^((?=^)(\s*))|((\s*)(?>$))/si', '', $source['G']);
            $temp['kelurahan'] = preg_replace( '/^((?=^)(\s*))|((\s*)(?>$))/si', '', $source['H']);
            $temp['jenis_produksi'] = $source['I'];
            $temp['no_telp'] = $source['K'];
            $temp['tahun_binaan'] = $source['N'];

            $res_ukm = Ukm::create($temp);
            $this->saveKategori($res_ukm['id'], $source['J']);
        }

        echo json_encode($dataArray);
    }

    public function saveKategori($ukm_id, $kategori){
        $data['ukm_id'] = $ukm_id;
        $data['kategori'] = $kategori;
        Kategori::create($data);
    }

    public function importExcel(){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('doc/umkm_mamin.xlsx'));
        $spreadsheet->setActiveSheetIndex(1);

        $dataArray = $spreadsheet->getActiveSheet()->rangeToArray('B2:AP1402',NULL,TRUE,TRUE,TRUE);

        $data_ukm = [];
        $duplicate_ukm = [];
        $index_data_ukm = 0;
        foreach($dataArray as $ukm){
            $new_ukm = true;
            foreach ($data_ukm as $exist_ukm) {
                if(strtolower($ukm['D']) == strtolower($exist_ukm['nama_pemilik']) || strtolower($ukm['B']) == strtolower($exist_ukm['nama_usaha'])){
                    $new_ukm = false;
                    $new_duplicate = true;
                    foreach($duplicate_ukm as $index_dup => $dup_ukm){
                        if (strtolower($ukm['D']) == strtolower($dup_ukm['original']['nama_pemilik']) || strtolower($ukm['B']) == strtolower($dup_ukm['original']['nama_usaha'])) {
                            if(strtolower($ukm['D']) == 'sri rahayu'){

                            }
                            $new_dup_ukm = [
                                'nama_usaha' => $ukm['B'],
                                'alamat' => $ukm['C'],
                                'nama_pemiilk' => $ukm['D'],
                                'nik' => $ukm['E'],
                                'no_telp' => $ukm['F'],
                                'jenis_kelamin' => $ukm['G'],
                                'alamat_pemilik_ktp' => $ukm['H'],
                                'alamat_pemilik_domisili' => $ukm['I'],
                                'no_siup' => $ukm['J'],
                                'no_nib' => $ukm['K'],
                                'no_tdp' => $ukm['L'],
                                'no_iumk' => $ukm['M'],
                                'no_pirt' => $ukm['N'],
                                'no_bpom' => $ukm['O'],
                                'merek' => $ukm['P'],
                                'halal' => $ukm['Q'],
                                'haki' => $ukm['R'],
                                'tahun_binaan' => $ukm['S'],
                                'kegiatan' => $ukm['T'],
                                'omset_2018' => $ukm['U'],
                                'omset_2019' => $ukm['V'],
                                'omset_2020' => $ukm['W'],
                                'omset_2021' => $ukm['X'],
                                'status_aktif' => $ukm['Y'],
                                'keterangan' => $ukm['Z'],
                                'sumber_pemodalan' => $ukm['AA'],
                                'jumlah_pemodalan' => $ukm['AB'],
                                'sumber_pinjaman' => $ukm['AC'],
                                'jumlah_pinjaman' => $ukm['AD'],
                                'total_aset' => $ukm['AE'],
                                'jenis_produksi' => $ukm['AF'],
                                'type_produk' => $ukm['AG'],
                                'harga_produk' => $ukm['AH'],
                                'satuan' => $ukm['AI'],
                                'kapasitas_produksi' => $ukm['AJ'],
                                'jangkauan_pemasaran' => $ukm['AK'],
                                'keterangan_jangkauan_pemasaran' => $ukm['AL'],
                                'jumlah_tenaga_kerja' => $ukm['AN'],
                                'sarana_prasarana' => $ukm['AO'],
                                'npwp' => $ukm['AP'],
                                'is_insert' => false
                            ];

                            array_push($duplicate_ukm[$index_dup]['duplicate'], $new_dup_ukm);

                            $new_duplicate = false;
                        }
                    }
                    if ($new_duplicate == true) {
                        $duplicate['original'] = $exist_ukm;
                        $duplicate['original']['is_insert'] = true;
                        $duplicate['duplicate'] = [];

                        $duplicate_data = [
                                'nama_usaha' => $ukm['B'],
                                'alamat' => $ukm['C'],
                                'nama_pemiilk' => $ukm['D'],
                                'nik' => $ukm['E'],
                                'no_telp' => $ukm['F'],
                                'jenis_kelamin' => $ukm['G'],
                                'alamat_pemilik_ktp' => $ukm['H'],
                                'alamat_pemilik_domisili' => $ukm['I'],
                                'no_siup' => $ukm['J'],
                                'no_nib' => $ukm['K'],
                                'no_tdp' => $ukm['L'],
                                'no_iumk' => $ukm['M'],
                                'no_pirt' => $ukm['N'],
                                'no_bpom' => $ukm['O'],
                                'merek' => $ukm['P'],
                                'halal' => $ukm['Q'],
                                'haki' => $ukm['R'],
                                'tahun_binaan' => $ukm['S'],
                                'kegiatan' => $ukm['T'],
                                'omset_2018' => $ukm['U'],
                                'omset_2019' => $ukm['V'],
                                'omset_2020' => $ukm['W'],
                                'omset_2021' => $ukm['X'],
                                'status_aktif' => $ukm['Y'],
                                'keterangan' => $ukm['Z'],
                                'sumber_pemodalan' => $ukm['AA'],
                                'jumlah_pemodalan' => $ukm['AB'],
                                'sumber_pinjaman' => $ukm['AC'],
                                'jumlah_pinjaman' => $ukm['AD'],
                                'total_aset' => $ukm['AE'],
                                'jenis_produksi' => $ukm['AF'],
                                'type_produk' => $ukm['AG'],
                                'harga_produk' => $ukm['AH'],
                                'satuan' => $ukm['AI'],
                                'kapasitas_produksi' => $ukm['AJ'],
                                'jangkauan_pemasaran' => $ukm['AK'],
                                'keterangan_jangkauan_pemasaran' => $ukm['AL'],
                                'jumlah_tenaga_kerja' => $ukm['AN'],
                                'sarana_prasarana' => $ukm['AO'],
                                'npwp' => $ukm['AP'],
                                'is_insert' => false
                        ];

                        array_push($duplicate['duplicate'], $duplicate_data);

                        array_push($duplicate_ukm, $duplicate);
                    }

                }
            }
            if ($new_ukm == true) {
                $data_ukm[$index_data_ukm]['nama_usaha'] = $ukm['B'];
                $data_ukm[$index_data_ukm]['alamat'] = $ukm['C'];
                $data_ukm[$index_data_ukm]['nik'] = $ukm['E'];
                $data_ukm[$index_data_ukm]['nama_pemilik'] = $ukm['D'];
                $data_ukm[$index_data_ukm]['no_telp'] = $ukm['F'];
                $data_ukm[$index_data_ukm]['jenis_kelamin'] = $ukm['G'];
                $data_ukm[$index_data_ukm]['alamat_pemilik_ktp'] = $ukm['H'];
                $data_ukm[$index_data_ukm]['alamat_pemilik_domisili'] = $ukm['I'];
                $data_ukm[$index_data_ukm]['no_siup'] = $ukm['J'];
                $data_ukm[$index_data_ukm]['no_nib'] = $ukm['K'];
                $data_ukm[$index_data_ukm]['no_tdp'] = $ukm['L'];
                $data_ukm[$index_data_ukm]['no_iumk'] = $ukm['M'];
                $data_ukm[$index_data_ukm]['no_pirt'] = $ukm['N'];
                $data_ukm[$index_data_ukm]['no_bpom'] = $ukm['O'];
                $data_ukm[$index_data_ukm]['merek'] = $ukm['P'];
                $data_ukm[$index_data_ukm]['halal'] = $ukm['Q'];
                $data_ukm[$index_data_ukm]['haki'] = $ukm['R'];
                $data_ukm[$index_data_ukm]['tahun_binaan'] = $ukm['S'];
                $data_ukm[$index_data_ukm]['kegiatan'] = $ukm['T'];
                $data_ukm[$index_data_ukm]['omset_2018'] = $ukm['U'];
                $data_ukm[$index_data_ukm]['omset_2019'] = $ukm['V'];
                $data_ukm[$index_data_ukm]['omset_2020'] = $ukm['W'];
                $data_ukm[$index_data_ukm]['omset_2021'] = $ukm['X'];
                $data_ukm[$index_data_ukm]['status_aktif'] = $ukm['Y'];
                $data_ukm[$index_data_ukm]['keterangan'] = $ukm['Z'];
                $data_ukm[$index_data_ukm]['sumber_pemodalan'] = $ukm['AA'];
                $data_ukm[$index_data_ukm]['jumlah_pemodalan'] = $ukm['AB'];
                $data_ukm[$index_data_ukm]['sumber_pinjaman'] = $ukm['AC'];
                $data_ukm[$index_data_ukm]['jumlah_pinjaman'] = $ukm['AD'];
                $data_ukm[$index_data_ukm]['total_aset'] = $ukm['AE'];
                $data_ukm[$index_data_ukm]['jenis_produksi'] = $ukm['AF'];
                $data_ukm[$index_data_ukm]['type_produk'] = $ukm['AG'];
                $data_ukm[$index_data_ukm]['harga_produk'] = $ukm['AH'];
                $data_ukm[$index_data_ukm]['satuan'] = $ukm['AI'];
                $data_ukm[$index_data_ukm]['kapasitas_produksi'] = $ukm['AJ'];
                $data_ukm[$index_data_ukm]['jangkauan_pemasaran'] = $ukm['AK'];
                $data_ukm[$index_data_ukm]['keterangan_jangkauan_pemasaran'] = $ukm['AL'];
                $data_ukm[$index_data_ukm]['jumlah_tenaga_kerja'] = $ukm['AN'];
                $data_ukm[$index_data_ukm]['sarana_prasarana'] = $ukm['AO'];
                $data_ukm[$index_data_ukm]['npwp'] = $ukm['AP'];

                $index_data_ukm++;
            }
        }
        echo json_encode($duplicate_ukm);
        // echo json_encode($data_ukm);

        foreach ($data_ukm as $exist_ukm) {
            $this->store2($exist_ukm);
        }
    }

    public function importRevisiUkm(){
        $path = storage_path() . "/json/dup_ukm_lengkap.json";

        $json = json_decode(file_get_contents($path), true);

        $ukm_nik_null = [];

        foreach ($json as $data) {
            if($data['original']['is_insert'] == false){
                $this->deleteUkmDup($data);
            }

            foreach ($data['duplicate'] as $dup) {
                if($dup['is_insert'] == true){
                    unset($dup['is_insert']);
                    $dup['nama_pemilik'] = $dup['nama_pemiilk'];
                    unset($dup['nama_pemiilk']);

                    if($dup['nik'] != null && isset($dup['nik'])){
                        $this->store2($dup);
                    }
                    else {
                        array_push($ukm_nik_null, $dup);
                    }

                }
            }
        }

        echo json_encode($ukm_nik_null);
    }

    public function store2($ukm){
        $ukm = Ukm::create($ukm);
    }

    public function deleteUkmDup($ukm){
        if(isset($ukm['nik'])){
            Ukm2::where([
                'nik' => $ukm['nik'],
                'nama_usaha' => $ukm['nama_usaha'],
                'nama_pemilik' => $ukm['nama_pemilik']
            ])->delete();
        }
    }

    public function exportExcel(){
        $data_ukm = Ukm2::get();

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "No");
        $sheet->setCellValue('B1', "Nama Usaha");
        $sheet->setCellValue('C1', "Alamat");
        $sheet->setCellValue('D1', "Nama Pemilik");
        $sheet->setCellValue('E1', "NIK Pemilik");
        $sheet->setCellValue('F1', "Telepon");
        $sheet->setCellValue('G1', "Jenis Kelamin");
        $sheet->setCellValue('H1', "Alamat Pemilik Sesuai KTP");
        $sheet->setCellValue('I1', "Alamat Pemilik Domisili");
        $sheet->setCellValue('J1', "Siup");
        $sheet->setCellValue('K1', "NIB");
        $sheet->setCellValue('L1', "TDP");
        $sheet->setCellValue('M1', "IUMK");
        $sheet->setCellValue('N1', "PIRT");
        $sheet->setCellValue('O1', "BPOM");
        $sheet->setCellValue('P1', "Merek");
        $sheet->setCellValue('Q1', "Halal");
        $sheet->setCellValue('R1', "Haki");
        $sheet->setCellValue('S1', "Tahun Binaan");
        $sheet->setCellValue('T1', "Kegiatan/Intervensi");
        $sheet->setCellValue('U1', "Omset 2018");
        $sheet->setCellValue('V1', "Omset 2019");
        $sheet->setCellValue('W1', "Omset 2020");
        $sheet->setCellValue('X1', "Omset 2021");
        $sheet->setCellValue('Y1', "Status (Aktif/Tidak)");
        $sheet->setCellValue('Z1', "Keterangan");
        $sheet->setCellValue('AA1', "Sumber Pemodalan");
        $sheet->setCellValue('AB1', "Jumlah Pemodalan");
        $sheet->setCellValue('AC1', "Sumber Pinjaman");
        $sheet->setCellValue('AD1', "Jumlah Pinjaman");
        $sheet->setCellValue('AE1', "Total Aset");
        $sheet->setCellValue('AF1', "Jenis Produksi");
        $sheet->setCellValue('AG1', "Type Produk");
        $sheet->setCellValue('AH1', "Harga Produk");
        $sheet->setCellValue('AI1', "Satuan");
        $sheet->setCellValue('AJ1', "Kapasitas Produksi Perbulan");
        $sheet->setCellValue('AK1', "Jangkauan Pemasaran");
        $sheet->setCellValue('AL1', "Keterangan jangkauan pemasaran");
        $sheet->setCellValue('AM1', "Jumlah Tenaga Kerja");
        $sheet->setCellValue('AN1', "Sarana Prasarana");
        $sheet->setCellValue('AO1', "NPWP");

        $i = 2;
        $no = 1;
        foreach ($data_ukm as $ukm) {
            $sheet->setCellValue('A'.$i, $no);
            $sheet->setCellValue('B'.$i, $ukm['nama_usaha']);
            $sheet->setCellValue('C'.$i, $ukm['alamat']);
            $sheet->setCellValue('D'.$i, $ukm['nama_pemilik']);
            $sheet->setCellValue('E'.$i, "'" . $ukm['nik']);
            $sheet->setCellValue('F'.$i, $ukm['no_telp']);
            $sheet->setCellValue('G'.$i, $ukm['jenis_kelamin']);
            $sheet->setCellValue('H'.$i, $ukm['alamat_pemilik_ktp']);
            $sheet->setCellValue('I'.$i, $ukm['alamat_pemilik_domisili']);
            $sheet->setCellValue('J'.$i, $ukm['no_siup']);
            $sheet->setCellValue('K'.$i, $ukm['no_nib']);
            $sheet->setCellValue('L'.$i, $ukm['no_tdp']);
            $sheet->setCellValue('M'.$i, $ukm['no_iumk']);
            $sheet->setCellValue('N'.$i, $ukm['no_pirt']);
            $sheet->setCellValue('O'.$i, $ukm['no_bpom']);
            $sheet->setCellValue('P'.$i, $ukm['merek']);
            $sheet->setCellValue('Q'.$i, $ukm['halal']);
            $sheet->setCellValue('R'.$i, $ukm['haki']);
            $sheet->setCellValue('S'.$i, $ukm['tahun_binaan']);
            $sheet->setCellValue('T'.$i, $ukm['kegiatan']);
            $sheet->setCellValue('U'.$i, $ukm['omset_2018']);
            $sheet->setCellValue('V'.$i, $ukm['omset_2019']);
            $sheet->setCellValue('W'.$i, $ukm['omset_2020']);
            $sheet->setCellValue('X'.$i, $ukm['omset_2021']);
            $sheet->setCellValue('Y'.$i, $ukm['status_aktif']);
            $sheet->setCellValue('Z'.$i, $ukm['keterangan']);
            $sheet->setCellValue('AA'.$i, $ukm['sumber_pemodalan']);
            $sheet->setCellValue('AB'.$i, $ukm['jumlah_pemodalan']);
            $sheet->setCellValue('AC'.$i, $ukm['sumber_pinjaman']);
            $sheet->setCellValue('AD'.$i, $ukm['jumlah_pinjaman']);
            $sheet->setCellValue('AE'.$i, $ukm['total_aset']);
            $sheet->setCellValue('AF'.$i, $ukm['jenis_produksi']);
            $sheet->setCellValue('AG'.$i, $ukm['type_produk']);
            $sheet->setCellValue('AH'.$i, $ukm['harga_produk']);
            $sheet->setCellValue('AI'.$i, $ukm['satuan']);
            $sheet->setCellValue('AJ'.$i, $ukm['kapasitas_produksi']);
            $sheet->setCellValue('AK'.$i, $ukm['jangkauan_pemasaran']);
            $sheet->setCellValue('AL'.$i, $ukm['keterangan_jangkauan_pemasaran']);
            $sheet->setCellValue('AM'.$i, $ukm['jumlah_tenaga_kerja']);
            $sheet->setCellValue('AN'.$i, $ukm['sarana_prasarana']);
            $sheet->setCellValue('AO'.$i, $ukm['npwp']);

            $i++;
            $no++;
        }

       $filename = "Data_UKM_Mamin.xlsx";
       $writer = new Xlsx($spreadsheet);
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment; filename="'. urlencode($filename).'"');
       $writer->save('php://output');
    }

    public function updateField(){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('doc/umkm_baru.xlsx'));
        $spreadsheet->setActiveSheetIndex(1);

        $dataArray = $spreadsheet->getActiveSheet()->rangeToArray('B2:AP1402',NULL,TRUE,TRUE,TRUE);

        foreach ($dataArray as $source) {
            $ukm = Ukm::where([
                'nik' => $source['E']
            ])->first();

            if($ukm != null){
                Ukm::where('id', $ukm->id)->update([
                    'no_nib' => $source['K'],
                    'no_tdp' => $source['L'],
                    'no_iumk' => $source['M'],
                    'no_pirt' => $source['N'],
                    'no_bpom' => $source['O'],
                    'jumlah_pemodalan' => $source['AB'],
                    'sumber_pemodalan' => $source['AA'],
                    'jumlah_pinjaman' => $source['AD'],
                    'sumber_pinjaman' => $source['AC'],
                    'jenis_kelamin' => $source['G'],
                    'haki' => $source['R'],
                    'status' => $source['Y'],
                    'total_aset' => $source['AE'],
                    'jml_tenaga_kerja' => $source['AN'],
                    'sarana_prasarana' => $source['AO'],
                    'npwp' => $source['AP']
                ]);
            }
        }
    }

    public function compareBinaan(){
        $path = storage_path() . "/fix/ukm_binaan.xlsx";
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $spreadsheet->setActiveSheetIndex(0);
        $dataArray = $spreadsheet->getActiveSheet()->rangeToArray('B3:I202',NULL,TRUE,TRUE,TRUE);
        $final = [];
        foreach ($dataArray as $source) {
            $ukm = Ukm::where('nik', '=', preg_replace( '/^((?=^)(\s*))|((\s*)(?>$))/si', '', $source['D']))
            ->orWhereRaw('lower(nama_usaha) = (?)', [preg_replace( '/^((?=^)(\s*))|((\s*)(?>$))/si', '', strtolower($source['B']))])
            ->first();

            $result['new'] = $source;
            $result['exist'] = $ukm;

            if($ukm != null){
                Ukm::where('id', $ukm->id)->update([
                    'isBinaan' => true
                ]);
                array_push($final, $result);
            }

        }

        echo json_encode($final);
    }
}

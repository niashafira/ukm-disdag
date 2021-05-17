<?php

namespace App\Http\Controllers;

use App\Models\Intervensi;
use App\Models\SertifikasiHalal;
use App\Models\SertifikasiMerek;
use App\Models\Ukm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $ukm = Ukm::get();
        $count_ukm = $ukm->count();

        $intervensi = Intervensi::get();
        $count_intervensi = $intervensi->count();

        $year = date("Y");
        $intervensi_year = Intervensi::whereYear('tanggal_mulai', '=', $year)->get();
        $count_intervensi_year = $intervensi_year->count();

        //GRAFIK JUMLAH INTERVENSI

        $pelatihan = Intervensi::where('jenis_intervensi', '=', 'pelatihan');
        $count_pelatihan = $pelatihan->count();

        $pameran = Intervensi::where('jenis_intervensi', '=', 'pameran');
        $count_pameran = $pameran->count();

        $pemasaran = Intervensi::where('jenis_intervensi', '=', 'pemasaran');
        $count_pemasaran = $pemasaran->count();

        $lainnya = Intervensi::where('jenis_intervensi', '=', 'lainnya');
        $count_lainnya = $lainnya->count();

        $sertifikasi_halal = SertifikasiHalal::get();
        $count_sertifikasi_halal = $sertifikasi_halal->count();

        $sertifikasi_merek = SertifikasiMerek::get();
        $count_sertifikasi_merek = $sertifikasi_merek->count();

        $count_jenis_intervensi = [$count_pelatihan, $count_pameran, $count_pemasaran, $count_sertifikasi_halal, $count_sertifikasi_merek];

        //GRAFIK PERTUMBUHAN INTERVENSI
        $pertumbuhan_intervensi = $this->pertumbuhanIntervensi();


        return view('dashboard', compact(
            'count_ukm',
            'count_intervensi',
            'count_intervensi_year',
            'year',
            'count_jenis_intervensi',
            'pertumbuhan_intervensi'
        ));
    }

    public function pertumbuhanIntervensi(){
        $year_now = date("Y");
        $year = 2017;
        $index_count = 0;
        while($year <= $year_now){
            $pelatihan = Intervensi::where('jenis_intervensi', '=', 'pelatihan')->whereYear('tanggal_mulai', '=', $year)->get();
            $count_pelatihan = $pelatihan->count();

            $pemasaran = Intervensi::where('jenis_intervensi', '=', 'pemasaran')->whereYear('tanggal_mulai', '=', $year)->get();
            $count_pemasaran = $pemasaran->count();

            $pameran = Intervensi::where('jenis_intervensi', '=', 'pameran')->whereYear('tanggal_mulai', '=', $year)->get();
            $count_pameran = $pameran->count();

            $lainnya = Intervensi::where('jenis_intervensi', '=', 'lainnya')->whereYear('tanggal_mulai', '=', $year)->get();
            $count_lainnya = $lainnya->count();

            $sertifikasi_halal = SertifikasiHalal::whereYear('tgl_permohonan', '=', $year)->get();
            $count_sertifikasi_halal = $sertifikasi_halal->count();

            $sertifikasi_merek = SertifikasiMerek::whereYear('tgl_berkas_kemenkumham', '=', $year)->get();
            $count_sertifikasi_merek = $sertifikasi_merek->count();

            $count_total = $count_pelatihan + $count_pemasaran + $count_pameran + $count_lainnya + $count_sertifikasi_halal + $count_sertifikasi_merek;

            $res['data'][$index_count] = $count_total;
            $res['years'][$index_count] = $year;

            $index_count++;
            $year++;
        }

        return $res;
    }
}

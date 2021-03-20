<?php

namespace App\Http\Controllers;

use App\Models\Intervensi;
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

        $pelatihan = Intervensi::where('jenis_intervensi', '=', 'pelatihan');
        $count_pelatihan = $pelatihan->count();

        $pameran = Intervensi::where('jenis_intervensi', '=', 'pameran');
        $count_pameran = $pameran->count();

        $pemasaran = Intervensi::where('jenis_intervensi', '=', 'pemasaran');
        $count_pemasaran = $pemasaran->count();

        $lainnya = Intervensi::where('jenis_intervensi', '=', 'lainnya');
        $count_lainnya = $lainnya->count();

        $sertifikasi_halal = Intervensi::where('jenis_intervensi', '=', 'sertifikasi_halal');
        $count_sertifikasi_halal = $sertifikasi_halal->count();

        $sertifikasi_merek = Intervensi::where('jenis_intervensi', '=', 'sertifikasi_merek');
        $count_sertifikasi_merek = $sertifikasi_merek->count();

        $count_jenis_intervensi = [$count_pelatihan, $count_pameran, $count_pemasaran, $count_sertifikasi_halal, $count_sertifikasi_merek, $count_lainnya];

        return view('dashboard', compact(
            'count_ukm',
            'count_intervensi',
            'count_intervensi_year',
            'year',
            'count_jenis_intervensi'
        ));
    }
}

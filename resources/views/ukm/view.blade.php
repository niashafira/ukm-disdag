@extends('template-metronics.index')

@section('title')
Profil UKM
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>Nama UKM</h6>
                        @{{ ukm.profil.nama_usaha }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>Nama Pemilik</h6>
                        @{{ ukm.profil.nama_pemilik }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>NIK Pemilik</h6>
                        @{{ ukm.profil.nik }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>Alamat</h6>
                        @{{ ukm.profil.alamat }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>No Telephone</h6>
                        @{{ ukm.profil.no_telp }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>NPWP</h6>
                        @{{ ukm.profil.npwp }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>Jenis Produksi</h6>
                        @{{ ukm.profil.jenis_produksi }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>Tahun Binaan</h6>
                        @{{ ukm.profil.tahun_binaan }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>Status</h6>
                        @{{ ukm.profil.status }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>No SIUP</h6>
                        @{{ ukm.profil.no_siup }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>No TDP</h6>
                        @{{ ukm.profil.no_tdp }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>No NIB</h6>
                        @{{ ukm.profil.no_nib }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>No BPOM</h6>
                        @{{ ukm.profil.no_bpom }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>No IUMK</h6>
                        @{{ ukm.profil.no_iumk }}
                    </div>
                    <div class="col-md-6" style="margin-top: 3%">
                        <h6>No PIRT</h6>
                        @{{ ukm.profil.no_pirt }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 3%">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3>Intervensi yang Diikuti</h3>
                <hr>
                <table id="table-intervensi" class="table table-bordered" style="margin-top:3%">
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-white">No</th>
                            <th class="text-white text-nowrap">Jenis Intervensi</th>
                            <th class="text-white">Nama Intervensi</th>
                            <th class="text-white">Tanggal</th>
                            <th class="text-white">Deskripsi</th>
                            <th class="text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(intervensi, index) in ukm.intervensi" :key="index">
                            <td>@{{ index + 1 }}</td>
                            <td>@{{ intervensi.jenis_intervensi }}</td>
                            <td>@{{ intervensi.nama_intervensi }}</td>
                            <td class="text-nowrap">@{{ intervensi.tanggal_mulai }}</td>
                            <td>@{{ intervensi.deskripsi }}</td>
                            <td><a :href="intervensi.linkDetail" target="_blank" class="btn btn-sm btn-info"><span class="fa fa-eye"></span> Detail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
    @include('ukm.viewJs')
@endsection

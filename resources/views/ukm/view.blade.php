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
                <h3>Sertifikasi Merek</h3>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-white">Nama Merek</th>
                            <th class="text-white">Tgl Permohonan</th>
                            <th class="text-white">No Permohonan</th>
                            <th class="text-white">Status</th>
                            <th class="text-white">No Sertifikat</th>
                            <th class="text-white">Tgl Sertifikat</th>
                            <th class="text-white">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(merek, index) in sertifikasi.merek" :key="index">
                            <td>@{{ merek.nama_merek }}</td>
                            <td>@{{ merek.tgl_berkas_kemenkumham }}</td>
                            <td>@{{ merek.no_permohonan }}</td>
                            <td>@{{ merek.status }}</td>
                            <td>@{{ merek.no_sertifikat }}</td>
                            <td>@{{ merek.tgl_sertifikat }}</td>
                            <td>@{{ merek.keterangan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 3%">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3>Sertifikasi Halal</h3>
                <hr>
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-white">Tgl Permohonan</th>
                            <th class="text-white">Status</th>
                            <th class="text-white">No Sertifikat</th>
                            <th class="text-white">Tgl Sertifikat</th>
                            <th class="text-white">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(halal, index) in sertifikasi.halal" :key="index">
                            <td>@{{ halal.tgl_permohonan }}</td>
                            <td>@{{ halal.status }}</td>
                            <td>@{{ halal.no_sertifikat }}</td>
                            <td>@{{ halal.tgl_sertifikat }}</td>
                            <td>@{{ halal.keterangan }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 3%">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3>Omset</h3>
                <hr>
                <button v-on:click="openModalOmset()" class="btn btn-sm btn-primary"><span class="fa fa-pen"></span> Edit Omset</button>

                <div id="chartOmset"></div>
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
                            <td><a :href="intervensi.linkDetail" target="_blank" class="btn btn-sm btn-info"><span
                                        class="fa fa-eye"></span> Detail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-omset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Omset</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button v-on:click="tambahOmset()" class="btn btn-sm btn-success"><span class="fa fa-plus"></span> Tambah</button>
                <table class="table table-bordered" style="margin-top: 3%">
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-white text-center">No</th>
                            <th class="text-white text-center">Bulan</th>
                            <th class="text-white text-center">Jumlah Produk Terjual</th>
                            <th class="text-white text-center">Omset</th>
                            <th class="text-white text-center">Keterangan</th>
                            <th class="text-white text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="newOmset != ''">
                            <td></td>
                            <td>
                                <input id="bulan-omset" type="month" class="form-control" v-model="newOmset.tanggal">
                            </td>
                            <td>
                                <input type="number" class="form-control" v-model="newOmset.jml_produk_terjual">
                            </td>
                            <td>
                                <input type="number" class="form-control" v-model="newOmset.nominal">
                            </td>
                            <td>
                                <input type="text" class="form-control" v-model="newOmset.keterangan">
                            </td>
                            <td>
                                <button v-on:click="simpanOmset()" class="btn btn-success btn-sm"><span class="fa fa-check"></span> Simpan</button>
                            </td>
                        </tr>
                        <tr v-for="(omset, index) in omset" :key="index">
                            <td>@{{ index+1 }}</td>
                            <td>
                                <div v-if="omset.isEdit == false">@{{ omset.tanggal }}</div>
                                <div v-else>
                                    <input type="month" class="form-control" v-model="omset.tanggal">
                                </div>
                            </td>
                            <td>
                                <div v-if="omset.isEdit == false">@{{ omset.jml_produk_terjual }}</div>
                                <div v-else>
                                    <input type="number" class="form-control" v-model="omset.jml_produk_terjual">
                                </div>
                            </td>
                            <td>
                                <div v-if="omset.isEdit == false">@{{ omset.nominal }}</div>
                                <div v-else>
                                    <input type="number" class="form-control" v-model="omset.nominal">
                                </div>
                            </td>
                            <td>
                                <div v-if="omset.isEdit == false">@{{ omset.keterangan }}</div>
                                <div v-else>
                                    <input type="text" class="form-control" v-model="omset.keterangan">
                                </div>
                            </td>
                            <td class="text-center">
                                <button v-on:click="updateOmset(omset, index)" v-if="omset.isEdit == true" class="btn btn-success btn-sm"><span class="fa fa-check"></span></button>
                                <button v-on:click="editOmset(omset)" v-if="omset.isEdit == false" class="btn btn-warning btn-sm"><span class="fa fa-pen"></span></button>
                                <button v-on:click="deleteOmset(omset)" v-if="omset.isEdit == false" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
@include('ukm.viewJs')
@endsection

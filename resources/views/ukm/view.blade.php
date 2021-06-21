@extends('template-metronics.index')

@section('title')
Profil UKM
@endsection

@section('style')
    <style>
        .dataTables_wrapper .dataTable th.sorting_asc, .dataTables_wrapper .dataTable td.sorting_asc{
            color: white !important;
        }

        .dataTables_wrapper .dataTable th.sorting_desc, .dataTables_wrapper .dataTable td.sorting_desc{
            color: white !important;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" v-for="(tab, index) in mainTabs" :key="index">
                <a :id="'link-' + tab.id" class="nav-link" data-toggle="tab" :href="'#'+tab.id">
                    <span class="nav-icon">
                        <i :class="tab.icon"></i>
                    </span>
                    <span class="nav-text">@{{ tab.nama }}</span>
                </a>
            </li>
        </ul>

        <div class="tab-content mt-5" id="myTabContent">
            <div class="tab-pane fade active show" id="tab-profil" role="tabpanel" aria-labelledby="tab-profil">
                <div class="col-md-12">
                    <button class="btn btn-warning btn-sm mb-3"><span class="fa fa-pencil-alt"></span> Edit Profil</button>
                    <form id="form-ukm">
                        <table class="table table-striped" style="font-size: 14px;">
                            <tr style="background-color: #07a4bd !important; color: white">
                                <th colspan="3"><span class="fa fa-user-circle"></span> PROFIL UKM</th>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">Nama UKM</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.nama_usaha }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">Nama Pemilik</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.nama_pemilik }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">NIK</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.nik }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">No Telp</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.no_telp }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">Alamat</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.alamat }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">Kecamatan</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.nama_kecamatan }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">Kelurahan</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.nama_kelurahan }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">Kategori Produk</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    <span v-for="(kategori, index) in ukm.kategori" class="badge badge-primary text-capitalize mr-3">@{{ kategori.nama }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">NPWP</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.npwp }}
                                </td>
                            </tr>
                            <tr style="background-color: #07a4bd !important; color: white">
                                <th colspan="3"><span class="fa fa-scroll"></span> IJIN USAHA</th>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">SIUP</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.no_siup }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">NIB</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.no_nib }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">IUMK</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.no_iumk }}
                                </td>
                            </tr>
                            <tr>
                                <td class="align-middle" style="width: 15%">PIRT</td>
                                <td class="align-middle" style="width: 2%"> : </td>
                                <td class="align-middle">
                                    @{{ ukm.no_pirt }}
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-omset" role="tabpanel" aria-labelledby="tab-omset">
                <div class="col-md-12">
                    <h3>Data Omset</h3>
                    <div class="row mt-5">
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-omset"><span class="fa fa-cogs"></span> Manage Data Omset</button>
                            <canvas id="chart-omset"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-omset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Manage Data Omset</h5>
            </div>
            <div class="modal-body">
                <form id="form-omset">
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group">
                                <label>Bulan</label>
                                <input name="bulan" v-model="formOmset.tanggal" type="month" class="form-control">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label>Produk Terjual</label>
                                <input name="jml_terjual" v-model="formOmset.jml_produk_terjual" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-group">
                                <label>Omset</label>
                                <input name="omset" v-model="formOmset.nominal" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label></label>
                                <button type="button" v-on:click="simpanOmset()" class="btn btn-sm btn-success form-control"><span class="fa fa-save"></span> Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <table class="table table-bordered" id="table-omset">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-white text-center">Bulan</th>
                            <th class="text-white text-center">Jumlah Produk Terjual</th>
                            <th class="text-white text-center">Omset</th>
                            <th class="text-white text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(omset, index) in ukm.omset">
                            <td class="text-center">
                                <span v-if="omset.isEdit == false"> @{{ new Date(omset.tanggal).toString('MMMM yyyy') }} </span>
                                <div v-else>
                                    <input type="month" class="form-control" v-model="omset.tanggal">
                                </div>
                            </td>
                            <td class="text-center">
                                <span v-if="omset.isEdit == false">@{{ omset.jml_produk_terjual }}</span>
                                <div v-else>
                                    <input type="number" class="form-control" v-model="omset.jml_produk_terjual">
                                </div>
                            </td>
                            <td class="text-center">
                                <span v-if="omset.isEdit == false">@{{ omset.nominal }}</span>
                                <div v-else>
                                    <input type="number" class="form-control" v-model="omset.nominal">
                                </div>
                            </td>
                            <td class="text-center">
                                <span v-if="omset.isEdit == false">
                                    <button v-on:click="editOmset(omset)" class="btn btn-sm btn-warning"><span class="fa fa-pen"></span></button>
                                    <button v-on:click="deleteOmset(omset.id)" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></button>
                                </span>
                                <span v-else>
                                    <button v-on:click="updateOmset(omset)" class="btn bnt-sm btn-success"><span class="fa fa-save"></span></button>
                                </span>
                            </td>
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

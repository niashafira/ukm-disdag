@extends('template-metronics.index')

@section('title')
Profil UKM
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
        </div>
    </div>
</div>

@endsection

@section('script')
@include('ukm.viewJs')
@endsection

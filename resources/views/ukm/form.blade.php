@extends('template-metronics.index')

@section('title')
Form UKM
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

    <h3>Detail UKM</h3>
    <hr>
    <form id="form-ukm">
        <table class="table table-striped" style="font-size: 14px;">
            <tr style="background-color: #07a4bd !important; color: white">
                <th colspan="3"><span class="fa fa-user-circle"></span> PROFIL UKM</th>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">Nama UKM</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="nama_usaha" v-model="ukm.nama_usaha" type="text" class="form-control form-control-sm" placeholder="Nama UKM">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">Nama Pemilik</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="nama_pemilik" v-model="ukm.nama_pemilik" type="text" class="form-control form-control-sm" placeholder="Nama Pemilik">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">NIK</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="nik" v-model="ukm.nik" type="text" class="form-control form-control-sm" placeholder="NIK">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">No Telp</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="no_telp" v-model="ukm.no_telp" type="text" class="form-control form-control-sm" placeholder="No Telepon">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">Alamat</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="alamat" v-model="ukm.alamat" type="text" class="form-control form-control-sm" placeholder="Alamat">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">Kecamatan</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <select v-on:change="changeKecamatan()" id="kecamatan" class='form-control' v-model='kecamatan' v-select='kecamatan'>
                            <option v-for="(kecamatan, index) in dataKecamatan" :key="index" :value=kecamatan>@{{ kecamatan.kcm_nama }}</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">Kelurahan</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <select v-on:change="changeKelurahan()" id="kelurahan" class='form-control' v-model='kelurahan' v-select='kelurahan'>
                            <option v-for="(kelurahan, index) in dataKelurahan" :key="index" :value=kelurahan>@{{ kelurahan.klh_nama }}</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">Kategori Produk</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-check form-check-inline" v-for="(kategori, index) in dataKategori" :key="index">
                        <input name="kategori" v-model="kategori.active" class="form-check-input" type="checkbox" :id="'inlineCheckbox'+index">
                        <label class="form-check-label text-capitalize" :for="'inlineCheckbox'+index">@{{ kategori.nama }}</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">NPWP</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="NPWP" v-model="ukm.npwp" type="text" class="form-control form-control-sm" placeholder="NPWP">
                    </div>
                </td>
            </tr>
            <tr style="background-color: #07a4bd !important; color: white">
                <th colspan="3"><span class="fa fa-scroll"></span> IJIN USAHA</th>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">SIUP</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="no_siup" v-model="ukm.no_siup" type="text" class="form-control form-control-sm" placeholder="No SIUP">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">NIB</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="no_nib" v-model="ukm.no_nib" type="text" class="form-control form-control-sm" placeholder="No NIB">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">IUMK</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="no_iumk" v-model="ukm.no_iumk" type="text" class="form-control form-control-sm" placeholder="No IUMK">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle" style="width: 15%">PIRT</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="no_pirt" v-model="ukm.no_pirt" type="text" class="form-control form-control-sm" placeholder="No PIRT">
                    </div>
                </td>
            </tr>
        </table>
    </form>

    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <button v-on:click="save()" class="btn btn-sm btn-success" style="float:right; margin-left:10px"><span class="fa fa-save"></span> Simpan</button>
        </div>
    </div>


@endsection

@section('script')
    @include('ukm.formJs')
@endsection

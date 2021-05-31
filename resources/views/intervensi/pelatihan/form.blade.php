@extends('template-metronics.index')

@section('title')
Form Pelatihan
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
        <div class="col-12">
            <button v-on:click="simpan()" class="btn btn-sm btn-success" style="float:right; margin-left:10px"><span class="fa fa-save"></span> Simpan</button>
        </div>
    </div>

    <h3>Detail Pelatihan</h3>
    <hr>
    <form id="form-intervensi">
    <table class="table table-striped" style="font-size: 14px;">
            <tr>
                <td class="align-middle" style="width: 15%">Nama Pelatihan</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="nama_intervensi" v-model="intervensi.nama_intervensi" type="text" class="form-control form-control-sm" placeholder="Nama Pelatihan">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Lokasi</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="lokasi" v-model="intervensi.lokasi" type="text" class="form-control form-control-sm" placeholder="Lokasi">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Tanggal Mulai</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="tanggal_mulai" v-model="intervensi.tanggal_mulai" type="date" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Tanggal Selesai</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="tanggal_selesai" v-model="intervensi.tanggal_selesai" type="date" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Keterangan</td>
                <td class="align-middle"> : </td>
                <td class="align-middle"><input name="keterangan" v-model="intervensi.deskripsi" type="text" class="form-control form-control-sm" placeholder="Keterangan"></td>
            </tr>
        </table>
    </form>

    <h3 style="margin-top: 3%">Data Peserta</h3>
    <hr>
    <button style="margin-bottom: 3%" v-on:click="openModalUkm()" class="btn btn-sm btn-info"><span class="fa fa-plus"> Tambah Peserta</span></button>

    <table id="table-peserta" class="table table-bordered">
        <thead class="bg-primary">
            <tr>
                <th class="text-white text-center">No</th>
                <th class="text-white">Nama UKM</th>
                <th class="text-white">Pemilik</th>
                <th class="text-white">NIK</th>
                <th class="text-white">Alamat</th>
                <th class="text-white">Keterangan</th>
                <th class="text-white text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(ukm, index) in intervensiDetail" :key="index">
                <td class="text-center">@{{ index + 1 }}</td>
                <td>@{{ ukm.nama_usaha }}</td>
                <td>@{{ ukm.nama_pemilik }}</td>
                <td>@{{ ukm.nik }}</td>
                <td>@{{ ukm.alamat }}</td>
                <td><input type="text" class="form-control form-control-sm" placeholder="Keterangan" v-model="ukm.keterangan"></td>
                <td class="text-center"><button v-on:click="deleteintervensiDetail(ukm, index)" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></button></td>
            </tr>
        </tbody>
    </table>

    <div id="modal-ukm" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih UKM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <table id="table-ukm" class="table table-bordered">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-white">No</th>
                                <th class="text-white">Nama</th>
                                <th class="text-white">Pemilik</th>
                                <th class="text-white">NIK</th>
                                <th class="text-white">No Telpon</th>
                                <th class="text-white">Alamat</th>
                                <th class="text-white">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('intervensi.pelatihan.formJs')
@endsection

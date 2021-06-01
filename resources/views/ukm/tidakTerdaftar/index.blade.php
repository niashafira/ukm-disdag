@extends('template-metronics.index')

@section('title')
    Data UKM Tidak Terdaftar
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
            <h3>Data UKM Tidak Terdaftar</h3>
        </div>
    </div>
    <div class="row" style="margin-top: 3%">
        <div class="col-12 table-responsive">
            <table class="table table-bordered" id="table-ukmTidakTerdaftar">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white">No</th>
                        <th class="text-white">Nama UKM</th>
                        <th class="text-white">Nama Pemilik</th>
                        <th class="text-white">NIK</th>
                        <th class="text-white">Alamat</th>
                        <th class="text-white">No Telp</th>
                        <th class="text-white">Intervensi</th>
                        <th class="text-white">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div id="modal-ukm" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih UKM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 3%">
                        <div class="col-12">
                            <h3>UKM untuk di sinkronkan</h3>
                            <table class="table table-bordered">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-white">Nama UKM</th>
                                        <th class="text-white">Nama Pemilik</th>
                                        <th class="text-white">NIK</th>
                                        <th class="text-white">No Telp</th>
                                        <th class="text-white">Alamat</th>
                                        <th class="text-white">Intervensi</th>
                                        <th class="text-white">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>@{{ selectedUkm.nama_usaha }}</td>
                                        <td>@{{ selectedUkm.nama_pemilik }}</td>
                                        <td>@{{ selectedUkm.nik }}</td>
                                        <td>@{{ selectedUkm.no_telp }}</td>
                                        <td>@{{ selectedUkm.alamat }}</td>
                                        <td>@{{ selectedUkm.nama_intervensi }}</td>
                                        <td><button v-on:click="openModalUkmBaru()" class="btn btn-success btn-sm"><span class="fa fa-save"></span> UKM Baru</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <h3>UKM Terdaftar</h3>
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

    <div id="modal-ukm-baru" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah UKM Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 3%">
                        <div class="col-12">
                            <form id="form-tambah">
                                <div class="form-group">
                                    <label>Nama UKM</label>
                                    <input name="nama_usaha" v-model="selectedUkm.nama_usaha" type="text" class="form-control" placeholder="Nama UKM">
                                </div>
                                <div class="form-group">
                                    <label>Nama Pemilik</label>
                                    <input name="nama_pemilik" v-model="selectedUkm.nama_pemilik" type="text" class="form-control" placeholder="Nama Pemilik">
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input name="nik" v-model="selectedUkm.nik" type="text" class="form-control" placeholder="NIK">
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input name="alamat" v-model="selectedUkm.alamat" type="text" class="form-control" placeholder="Alamat">
                                </div>
                                <div class="form-group">
                                    <label>No Telepon</label>
                                    <input name="no_telp" v-model="selectedUkm.no_telp" type="text" class="form-control" placeholder="No Telepon">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button v-on:click="submitNew()" class="btn btn-sm btn-success"><span class="fa fa-save"></span> Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('ukm.tidakTerdaftar.indexJs')
@endsection

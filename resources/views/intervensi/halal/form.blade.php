@extends('template-metronics.index')

@section('title')
Form Sertifikasi Halal
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
            <button v-on:click="save()" class="btn btn-sm btn-success" style="float:right; margin-left:10px"><span class="fa fa-save"></span> Simpan</button>
        </div>
    </div>

    <h3>Form Sertifikasi Halal</h3>
    <hr>
    <form id="form-intervensi">
    <table class="table table-striped" style="font-size: 14px;">
            <tr>
                <td class="align-middle" style="width: 15%">Nama UKM</td>
                <td class="align-middle" style="width: 2%"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input v-on:click="openModalUkm()" name="nama_usaha" v-model="nama_usaha" type="text" class="form-control form-control-sm" placeholder="Klik Disini" readonly>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Tanggal Pendaftaran</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="tgl_pendaftaran" v-model="intervensi.tgl_pendaftaran" type="date" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Tanggal Berkas Kemenag</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="tgl_berkas_kemenag" v-model="intervensi.tgl_berkas_kemenag" type="date" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Status</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <select name="status" v-on:change="changeStatus()" class="form-control" v-model="intervensi.status">
                            <option selected value="didaftar" selected>Didaftar</option>
                            <option value="sudah_keluar_sertifikat">Sudah Keluar Sertifikat</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                </td>
            </tr>
            <tr id="tgl_sertifikat" v-if="intervensi.status != undefined && intervensi.status == 'sudah_keluar_sertifikat'">
                <td class="align-middle">Tanggal Sertifikat</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="tgl_sertifikat" v-model="intervensi.tgl_sertifikat" type="date" class="form-control form-control-sm">
                    </div>
                </td>
            </tr>
            <tr id="no_sertifikat" v-if="intervensi.status != undefined && intervensi.status == 'sudah_keluar_sertifikat'">
                <td class="align-middle">No Sertifikat</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="no_sertifikat" v-model="intervensi.no_sertifikat" type="text" class="form-control form-control-sm" placeholder="No Sertifikat">
                    </div>
                </td>
            </tr>
            <tr>
                <td class="align-middle">Keterangan</td>
                <td class="align-middle"> : </td>
                <td class="align-middle">
                    <div class="form-group" style="margin-bottom: 0">
                        <input name="keterangan" v-model="intervensi.keterangan" type="text" class="form-control form-control-sm" placeholder="Keterangan">
                    </div>
                </td>
            </tr>
        </table>
    </form>

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
    @include('intervensi.halal.formJs')
@endsection

@extends('template-metronics.index')

@section('title')
Detail Pelatihan
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

    <div class="row" style="margin-bottom: 3%">
        <div class="col-12">
            <button v-on:click="openModalExport()" class="btn btn-sm btn-success"><span class="fa fa-file-excel"></span> Export Excel</button>
            <a :href="'/intervensi/pelatihan/edit/'+ intervensi.id" class="btn btn-sm btn-warning"><span class="fa fa-pen"></span> Edit</a>
        </div>
    </div>

    <h3>Detail Pelatihan</h3>
    <hr>
    <table class="table table-striped" style="font-size: 14px;">
        <tr>
            <td style="width: 15%">Nama Pelatihan</td>
            <td style="width: 2%"> : </td>
            <td>@{{ intervensi.nama_intervensi }}</td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td> : </td>
            <td>@{{ intervensi.lokasi }}</td>
        </tr>
        <tr>
            <td>Tanggal Mulai</td>
            <td> : </td>
            <td>@{{ intervensi.tanggal_mulai }}</td>
        </tr>
        <tr>
            <td>Tanggal Selesai</td>
            <td> : </td>
            <td>@{{ intervensi.tanggal_selesai }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td> : </td>
            <td>@{{ intervensi.deskripsi }}</td>
        </tr>
    </table>

    <h3 style="margin-top:3%">Data Peserta</h3>
    <hr>
    <div>
        <table class="table table-bordered" id="table-peserta">
            <thead>
                <tr class="bg-primary text-white">
                    <th class="text-center text-white" style="width:7%">No</th>
                    <th class="text-white">Nama UKM</th>
                    <th class="text-white">Pemilik</th>
                    <th class="text-white">NIK</th>
                    <th class="text-white">Alamat</th>
                    <th class="text-white">Keterangan</th>
                    <th style="width: 15%" class="text-center text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(detail, index) in intervensi_detail" :key="index">
                    <td class="text-center">@{{ index + 1 }}</td>
                    <td>@{{ detail.nama_usaha }}</td>
                    <td>@{{ detail.nama_pemilik }}</td>
                    <td>@{{ detail.nik }}</td>
                    <td>@{{ detail.alamat }}</td>
                    <td>@{{ detail.keterangan }}</td>
                    <td class="text-center">
                        <a :href="'/ukm/view/' + detail.ukm_id" target="_blank" class="btn btn-sm btn-info"><span class="fa fa-eye"></span> Lihat Profil</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Setting Field</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span>Pilih field untuk ditampilkan :</span>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check">
                            <input v-model="semua" v-on:click="checkAll()" class="form-check-input" type="checkbox" value="" id="semua">
                            <label class="form-check-label" for="semua">
                                Pilih Semua
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6" v-for="(field, index) in field_ukm" :key="index">
                        <div class="form-check">
                            <input v-on:change="checkField()" :disabled="field.key == 'nama_usaha' ? true : false" v-model="field.checked" class="form-check-input" type="checkbox" value="" :id="field.key">
                            <label class="form-check-label" :for="field.key">
                                @{{ field.value }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button v-on:click="submitExport()" type="button" class="btn btn-success btn-sm"><span class="fa fa-file-excel"></span> Export</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times-circle"></span> Batal</button>
            </div>
        </div>
        </div>
    </div>

@endsection

@section('script')
    @include('intervensi.pelatihan.viewJs')
@endsection

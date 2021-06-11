@extends('template-metronics.index')

@section('title')
Data Sertifikasi Merek
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
    <div class="col-12 grid-margin stretch-card">
        <h2>Data Sertifikasi Merek</h2><hr>
        <a href="/intervensi/SertifikasiMerek/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah Sertifikasi Merek</a>
        <div class="table-responsive">
            <table id="table-intervensi" class="table table-bordered table-stripped">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-center text-white" style="width:5%">No</th>
                        <th class="text-white">Nama UKM</th>
                        <th class="text-white">Nama Merek</th>
                        <th class="text-white">No Permohonan</th>
                        <th class="text-white">Tanggal Permohonan</th>
                        <th class="text-white">Tanggal Berkas Kemenkumham</th>
                        <th class="text-white">Status</th>
                        <th class="text-white">No Sertifikat</th>
                        <th class="text-white">Tanggal Sertifikat</th>
                        <th class="text-white">Keterangan</th>
                        <th class="text-center text-white" style="width:10%">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>

        var app = new Vue({
            el: '#app',
            data: {
                api: {
                    intervensiDT: "/intervensi/SertifikasiMerek/getMerekDT"
                }
            },

            mounted(){
                this.getIntervensiDT();
            },

            methods:{
                getIntervensiDT(){
                    let tableIntervensi = $('#table-intervensi').DataTable({
                        processing: true,
                        serverSide: true,
                        destroy: true,
                        order: [[ 3, "desc" ]],
                        ajax: {
                            url: this.api.intervensiDT,
                        },
                        columns: [
                            {
                                data: null,
                                sortable: false,
                                searchable: false,
                                class: 'text-center',
                                render: function (data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {data: 'nama_usaha'},
                            {data: 'nama_merek'},
                            {data: 'no_permohonan'},
                            {
                                data: 'tgl_permohonan',
                                class: 'text-nowrap',
                                render: function (data, type, row, meta) {
                                    return new Date(row.tgl_permohonan).toString("dd MMMM yyyy")
                                }
                            },
                            {
                                data: 'tgl_berkas_kemenkumham',
                                class: 'text-nowrap',
                                render: function (data, type, row, meta) {
                                    return new Date(row.tgl_berkas_kemenkumham).toString("dd MMMM yyyy")
                                }
                            },
                            {
                                data: 'status',
                                class: 'text-nowrap',
                                render: function (data, type, row, meta) {
                                    let status = row.status.replace(/_/g, " ", "g");
                                    return status.charAt(0).toUpperCase() + status.slice(1);
                                }
                            },
                            {data: 'no_sertifikat'},
                            {
                                data: 'tgl_sertifikat',
                                class: 'text-nowrap',
                                render: function (data, type, row, meta) {
                                    if(row.tgl_sertifikat == undefined) return "";
                                    return new Date(row.tgl_sertifikat).toString("dd MMMM yyyy");
                                }
                            },
                            {data: 'keterangan'},
                            {
                                data: 'null',
                                class: 'text-nowrap text-center',
                                render: function (data, type, row, meta) {
                                    let btn = "<a href='/intervensi/SertifikasiMerek/edit/"+ row.id +"' class='btn btn-sm btn-warning'><span class='fa fa-pencil-alt'></span></a>";
                                    return btn;
                                }
                            }
                        ]
                    });
                }
            }
        });

    </script>
@endsection

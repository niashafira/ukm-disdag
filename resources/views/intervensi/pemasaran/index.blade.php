@extends('template-metronics.index')

@section('title')
Data Intervensi Pemasaran
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
        <h2>Data Intervensi Pemasaran</h2><hr>
        <a href="/intervensi/pemasaran/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah Pemasaran</a>
        <table id="table-intervensi" class="table table-bordered table-stripped">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white" style="width:5%">No</th>
                    <th class="text-white">Nama Pemasaran</th>
                    <th class="text-white">Lokasi</th>
                    <th class="text-white" style="width: 10%">Tanggal</th>
                    <th class="text-white">Keterangan</th>
                    <th class="text-center text-white" style="width:10%">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection

@section('script')
    <script>

        var app = new Vue({
            el: '#app',
            data: {
                api: {
                    intervensiDT: "/intervensi/getIntervensiDT"
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
                            data: (d) => {
                                return $.extend( {}, d, {
                                    jenisIntervensi: 'pemasaran'
                                });
                            }
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
                            {data: 'nama_intervensi'},
                            {data: 'lokasi'},
                            {
                                data: 'tanggal_mulai',
                                class: 'text-nowrap',
                                render: function (data, type, row, meta) {
                                    return new Date(row.tanggal_mulai).toString("dd MMMM yyyy")
                                }
                            },
                            {data: 'deskripsi'},
                            {
                                data: 'null',
                                class: 'text-nowrap text-center',
                                render: function (data, type, row, meta) {
                                    let btn = "<a href='/intervensi/pemasaran/view/"+ row.id +"' style='margin-left: 1%' class='btn btn-sm btn-info'><span class='fa fa-eye'></span></a> ";
                                    btn += "<a href='/intervensi/pemasaran/edit/"+ row.id +"' class='btn btn-sm btn-warning'><span class='fa fa-pencil-alt'></span></a>";
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

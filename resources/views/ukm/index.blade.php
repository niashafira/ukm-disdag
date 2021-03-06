@extends('template-metronics.index')

@section('title')
Data UKM
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
        <div class="row">
            <div class="col-md-6">
                <a href="/ukm/create" class="btn btn-info btn-sm" id="btn-create"><span class="fa fa-plus"></span> Tambah UKM</a><br><br>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <div class="btn-group">
                    <button type="button" class="btn-sm btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Optimasi Data
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/ukm/tidakTerdaftar">UKM Belum Terdaftar</a>
                        <a class="dropdown-item" href="#">UKM Tanpa Kecamatan & Kelurahan</a>
                        <a class="dropdown-item" href="#">UKM Tanpa Kategori</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-10">
            <div class="col-md-12">
                <table id="table-ukm" class="table table-bordered table-stripped">
                    <thead>
                        <tr class="bg-primary">
                            <th class="text-white">No.</th>
                            <th class="text-white">Nama UKM</th>
                            <th class="text-white">Nama Pemilik UKM</th>
                            <th class="text-white">NIK</th>
                            <th class="text-white">No Telpon</th>
                            <th class="text-white">Alamat</th>
                            <th class="text-center text-white" style="width:10%">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')

<script>

    var app = new Vue({
        el: '#app',
        data: {
            ukm: ""
        },

        mounted(){
            this.initData();
        },

        methods:{
            initData(){
                $('#table-ukm').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    order: [[ 1, "asc" ]],
                    ajax: {
                        url: "/api/ukm",
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
                        {data: 'nama_pemilik'},
                        {data: 'nik'},
                        {data: 'no_telp'},
                        {data: 'alamat'},
                        {
                            data: 'null',
                            sortable: false,
                            class: 'text-nowrap text-center',
                            render: function (data, type, row, meta) {
                                let btn = "<a class='btn btn-sm btn-success' href='ukm/view/"+ row.id +"'><span class='fa fa-eye'></span> Detail</a>";
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

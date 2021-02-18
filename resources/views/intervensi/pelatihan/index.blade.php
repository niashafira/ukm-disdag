@extends('template-metronics.index')

@section('title')
Data Intervensi
@endsection

@section('content')


<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <a href="/intervensi/pelatihan/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah</a>
        <table id="table-intervensi" class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th class="text-center" style="width:7%">No</th>
                    <th>Nama Pelatihan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Keterangan</th>
                    <th class="text-center" style="width:25%">Aksi</th>
                </tr>
            </thead>
            <tr v-for="(intervensi, index) in intervensi" :key="index">
                <td class="text-center">@{{index+1}}</td>
                <td>@{{ intervensi.nama_intervensi }}</td>
                <td>@{{ intervensi.tanggal_mulai }}</td>
                <td>@{{ intervensi.tanggal_selesai }}</td>
                <td>@{{ intervensi.keterangan }}</td>
                <td class="text-center"><button class="btn btn-sm btn-info"><span class="fa fa-eye"></span></button></td>
            </tr>
        </table>
    </div>
</div>

@endsection

@section('script')
    <script>
        $("#table-intervensi").DataTable();

        var app = new Vue({
            el: '#app',
            data: {
                intervensi: <?= json_encode($intervensi); ?>
            },

            mounted(){

            },

            methods:{

            }
        });

    </script>
@endsection

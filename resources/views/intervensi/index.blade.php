@extends('template-metronics.index')

@section('title')
Data Intervensi
@endsection

@section('content')


<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <a href="/intervensi/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah</a>
        <table id="table-intervensi" class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th class="text-center" style="width:7%">No</th>
                    <th>Jenis Intervensi</th>
                    <th>Nama Intervensi</th>
                    <th>Deskripsi</th>
                    <th class="text-center" style="width:25%">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
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

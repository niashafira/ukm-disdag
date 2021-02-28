@extends('template-metronics.index')

@section('title')
Data UKM
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <a href="/ukm/create" class="btn btn-info btn-sm" id="btn-create"><span class="fa fa-plus"></span> Tambah UKM</a><br><br>
        <table id="table-ukm" class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama UKM</th>
                    <th>Nama Pemilik UKM</th>
                    <th>NIK</th>
                    <th>Alamat</th>
                    <th class="text-center" style="width:10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ukm, index) in ukm" :key="index">
                    <td>@{{ index + 1 }}</td>
                    <td>@{{ ukm.nama_usaha }}</td>
                    <td>@{{ ukm.nama_pemilik }}</td>
                    <td>@{{ ukm.nik }}</td>
                    <td>@{{ ukm.alamat }}</td>
                    <td class="text-center"><button class="btn btn-sm btn-success"><span class="fa fa-eye"></span> Detail</button></td>
                </tr>
            </tbody>
        </table>
        <div id="section-modal">
            @include('ukm.modal-form')
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
                var data = <?= json_encode($ukm); ?>;
                this.ukm = data;
                setTimeout(() => {
                    $('#table-ukm').DataTable();
                }, 10);
            },
        }
    });

</script>
@endsection

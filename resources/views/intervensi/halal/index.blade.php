@extends('template-metronics.index')

@section('title')
Data Intervensi
@endsection

@section('content')


<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <a href="/intervensi/SertifikatHalal/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah Sertifikat Halal</a>
        <table id="table-intervensi" class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th class="text-center" style="width:7%">No</th>
                    <th>Tanggal Pendaftaran</th>
                    <th>No. Pendaftaran</th>
                    <th>Keterangan</th>
                    <th class="text-center" style="width:25%">Aksi</th>
                </tr>
            </thead>
            <tr v-for="(intervensi, index) in intervensi" :key="index">
                <td class="text-center">@{{index+1}}</td>
                <td>@{{ intervensi.formatedTglPermohonan }}</td>
                <td>@{{ intervensi.no_permohonan }}</td>
                <td>@{{ intervensi.deskripsi }}</td>
                <td class="text-center" style="width:10%">
                    <a :href="'/intervensi/SertifikatHalal/view/'+ intervensi.id" class="btn btn-sm btn-info"><span class="fa fa-eye"></span></a>
                    <a :href="'/intervensi/SertifikatHalal/edit/'+ intervensi.id" class="btn btn-sm btn-warning"><span class="fa fa-pen"></span></a>
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection

@section('script')
    <script>

        var app = new Vue({
            el: '#app',
            data: {
                intervensi: ""
            },

            mounted(){
                this.initData();
            },

            methods:{
                initData(){
                    var data = <?= json_encode($intervensi); ?>;
                    data.forEach((intervensi, index) => {
                        intervensi.formatedTglPermohonan = this.changeDateFormat(intervensi.tgl_permohonan);
                    });
                    this.intervensi = data;
                    setTimeout(() => {
                        $("#table-intervensi").DataTable();
                    }, 10);

                },

                changeDateFormat(date){
                    var newDate = new Date(date);
                    var formatedDate = newDate.toString("dd MMMM yyyy");

                    return formatedDate;
                }
            }
        });

    </script>
@endsection

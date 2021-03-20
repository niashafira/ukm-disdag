@extends('template-metronics.index')

@section('title')
Data Intervensi
@endsection

@section('content')


<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <h2>Data Intervensi Lainnya</h2><hr>
        <a href="/intervensi/lainnya/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah Intervensi</a>
        <table id="table-intervensi" class="table table-bordered table-stripped">
            <thead>
                <tr class="bg-primary">
                    <th class="text-center text-white">No</th>
                    <th class="text-white" style="width:20%">Nama Intervensi</th>
                    <th class="text-white">Lokasi</th>
                    <th class="text-white">Tanggal Mulai</th>
                    <th class="text-white">Tanggal Selesai</th>
                    <th class="text-white">Keterangan</th>
                    <th class="text-center text-white" style="width:25%">Aksi</th>
                </tr>
            </thead>
            <tr v-for="(intervensi, index) in intervensi" :key="index">
                <td class="text-center">@{{index+1}}</td>
                <td>@{{ intervensi.nama_intervensi }}</td>
                <td>@{{ intervensi.lokasi }}</td>
                <td>@{{ intervensi.formatedTglMulai }}</td>
                <td>@{{ intervensi.formatedTglSelesai }}</td>
                <td>@{{ intervensi.deskripsi }}</td>
                <td class="text-center" style="width:10%">
                    <a :href="'/intervensi/lainnya/view/'+ intervensi.id" class="btn btn-sm btn-info"><span class="fa fa-eye"></span></a>
                    <a :href="'/intervensi/lainnya/edit/'+ intervensi.id" class="btn btn-sm btn-warning"><span class="fa fa-pen"></span></a>
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
                        if(intervensi.tanggal_mulai != null){
                            intervensi.formatedTglMulai = this.changeDateFormat(intervensi.tanggal_mulai);
                        }
                        if(intervensi.tanggal_selesai != null){
                            intervensi.formatedTglSelesai = this.changeDateFormat(intervensi.tanggal_selesai);
                        }

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

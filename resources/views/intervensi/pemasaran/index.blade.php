@extends('template-metronics.index')

@section('title')
Data Intervensi Pemasaran
@endsection

@section('content')


<div class="row">
    <div class="col-12 grid-margin stretch-card">

        <h2>Data Intervensi Pemasaran</h2><hr>

        <a href="/intervensi/pemasaran/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah Pemasaran</a>
        <table id="table-intervensi" class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th class="text-center" style="width:7%">No</th>
                    <th>Nama Pemasaran</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th class="text-center" style="width:25%">Aksi</th>
                </tr>
            </thead>
            <tr v-for="(intervensi, index) in intervensi" :key="index">
                <td class="text-center">@{{index+1}}</td>
                <td>@{{ intervensi.nama_intervensi }}</td>
                <td>@{{ intervensi.lokasi }}</td>
                <td>@{{ intervensi.deskripsi }}</td>
                <td class="text-center" style="width:10%">
                    <a :href="'/intervensi/pemasaran/view/'+ intervensi.id" class="btn btn-sm btn-info"><span class="fa fa-eye"></span></a>
                    <a :href="'/intervensi/pemasaran/edit/'+ intervensi.id" class="btn btn-sm btn-warning"><span class="fa fa-pen"></span></a>
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

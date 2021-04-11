@extends('template-metronics.index')

@section('title')
Data Intervensi Sertifikasi Merek
@endsection

@section('content')


<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <h2>Data Intervensi Sertifikasi Merek</h2><hr>
        <a href="/intervensi/SertifikasiMerek/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah</a>
        <table id="table-intervensi" class="table table-bordered table-stripped table-responsive">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center text-white" style="width:5%">No</th>
                    <th class="text-white" style="min-width: 150px">Nama UKM</th>
                    <th class="text-white" style="min-width: 100px">Nama Merek</th>
                    <th class="text-white text-nowrap">No. Permohonan</th>
                    <th class="text-white">Status</th>
                    <th class="text-white">No Sertifikat</th>
                    <th class="text-nowrap text-white">Tanggal Sertifikat</th>
                    <th class="text-white">Keterangan</th>
                    <th class="text-center text-white" style="width:25%">Aksi</th>
                </tr>
            </thead>
            <tr v-for="(intervensi, index) in intervensi" :key="index">
                <td class="text-center">@{{index+1}}</td>
                <td>@{{ intervensi.nama_usaha }}</td>
                <td>@{{ intervensi.nama_merek }}</td>
                <td>@{{ intervensi.no_permohonan }}</td>
                <td class="text-nowrap">
                    <span v-if="intervensi.status == 'Menunggu Proses Cetak' || intervensi.status == 'Menunggu Tanggapan'" class="badge badge-warning">@{{ intervensi.status }}</span>
                    <span v-if="intervensi.status == 'Sudah Keluar Sertifikat'" class="badge badge-success">@{{ intervensi.status }}</span>
                    <span v-if="intervensi.status == 'Ditolak'" class="badge badge-danger">@{{ intervensi.status }}</span>

                </td>
                <td>@{{ intervensi.no_sertifikat }}</td>
                <td>@{{ intervensi.tgl_sertifikat }}</td>
                <td>@{{ intervensi.keterangan }}</td>
                <td class="text-center" style="width:10%">
                    <a :href="'/intervensi/SertifikasiMerek/edit/'+ intervensi.id" class="btn btn-sm btn-warning"><span class="fa fa-pen"></span></a>
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
                        if(intervensi.tgl_sertifikat != undefined){
                            intervensi.tgl_sertifikat = new Date(intervensi.tgl_sertifikat).toString("dd MMMM yyyy");
                        }

                        if(intervensi.status == "ditolak"){
                            intervensi.status = "Ditolak"
                        }
                        else if(intervensi.status == "proses_cetak"){
                            intervensi.status = "Menunggu Proses Cetak"
                        }
                        else if(intervensi.status == "menunggu_tanggapan"){
                            intervensi.status = "Menunggu Tanggapan"
                        }
                        else if(intervensi.status == "sudah_keluar_sertifikat"){
                            intervensi.status = "Sudah Keluar Sertifikat"
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

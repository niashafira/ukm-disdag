@extends('template-metronics.index')

@section('title')
Data Referensi
@endsection

@section('content')


<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <a href="/referensi/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah</a>
        <table id="table-referensi" class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th class="text-center" style="width:7%">No</th>
                    <th>Kode Referensi</th>
                    <th>Keterangan</th>
                    <th class="text-center" style="width:25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(ref, index) in referensi" :key="index">
                    <td class="text-center">@{{ index+1 }} </td>
                    <td>@{{ ref.kode }}</td>
                    <td>@{{ ref.keterangan }}</td>
                    <td class="text-center" style="width: 22%">
                        <a :href="'/referensi/view/'+ ref.kode" class="btn btn-primary btn-edit btn-sm"><span
                                class="fa fa-eye"></span> View</a>
                        <a :href="'/referensi/edit/'+ ref.kode" class="btn btn-warning btn-edit btn-sm"><span
                                class="fa fa-pen"></span> Edit</a>
                        <button type="button" v-on:click="deleteReferensi(ref)" class="btn btn-danger btn-delete btn-sm"><span
                                class="fa fa-trash"></span> Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
    <script>
        $("#table-referensi").DataTable();

        var app = new Vue({
            el: '#app',
            data: {
                referensi: <?= json_encode($referensi); ?>
            },

            mounted(){

            },

            methods:{
                deleteReferensi(referensi){
                    console.log(referensi);

                    Swal.fire({
                    title: 'Apakah anda yakin ?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Mohon Tunggu !',
                                html: '',
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            });

                            axios.post('/referensi/delete', referensi).then(response => {
                                if(response.data == "success"){
                                    Swal.close();
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Data Berhasil Dihapus',
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    window.location = "/referensi";
                                }
                            });
                        }
                    });
                }
            }
        });

    </script>
@endsection

@extends('template-metronics.index')

@section('title')
Referensi
@endsection

@section('content')

    <div v-if="mode == 'view'" class="row">
        <div class="col-12">
            <a :href="'/referensi/edit/'+ referensi.kode" class="btn btn-sm btn-info" style="float:right; margin-left:10px"><span class="fa fa-pen"></span> Edit</a>
            <a :href="'/referensi'" class="btn btn-sm btn-warning" style="float:right;"><span class="fa fa-arrow-left"></span> Kembali</a>
        </div>
    </div>

    <h3>Referensi</h3>
    <hr>
    <form id="form-ref">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kode Referensi</label>
                    <input {{ $mode != 'create' ? 'readonly' : '' }} v-model="referensi.kode" autocomplete="off" type="text" class="form-control" name="kode" placeholder="Kode Referensi">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Keterangan</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="referensi.keterangan" autocomplete="off" type="text" class="form-control" name="keterangan" placeholder="Keterangan">
                </div>
            </div>
        </div>
    </form>
    <h3 style="margin-top:3%">Detail Referensi</h3>
    <hr>
    <button v-if="mode != 'view'" v-on:click="addDetail()" style="margin-bottom: 2%" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Tambah</button>
    <form id="form-detail-ref">
        <table class="table table-bordered" id="table-detail-ref">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <tr v-for="(refD, index) in referensi_detail" :key="index">
                    <td class="text-center">@{{ index+1 }}</td>
                    <td>
                        <input v-if="refD.readonly == true" readonly v-model="refD.key" type="text" class="form-control" />
                        <input v-else v-model="refD.key" type="text" class="form-control" />
                    </td>
                    <td>
                        <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="refD.val" type="text" class="form-control" />
                    </td>
                    <td>
                        <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="refD.keterangan" type="text" class="form-control" />
                    </td>
                    <td class="text-center">
                        <button type="button" v-on:click="deleteDetail(index)" class="btn btn-sm btn-danger btn-delete-ref"><span class="fa fa-trash"></span></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </form>

    <div v-if="mode != 'view'">
        <h3 style="margin-top:3%">Simpan Data Referensi</h3>
        <hr>

        <button v-on:click="submit()" type="button" class="btn btn-success btn-sm"><span class="fa fa-check"></span> Simpan</button>
    </div>
@endsection

@section('script')

<script>

    var app = new Vue({
        el: '#app',
        data: {
            referensi:{
                kode: "",
                keterangan: ""
            },
            referensi_detail: [
                {
                    id: "",
                    key: "",
                    val: "",
                    keterangan: "",
                    readonly: false
                }
            ],
            referensi_detail_delete: [],
            mode: <?= json_encode($mode); ?>
        },

        mounted(){
            if(this.mode == 'edit' || this.mode == 'view'){
                this.initData();
            }
        },

        methods:{

            initData(){
                var referensi = <?= json_encode($referensi) ?>;
                this.referensi.kode = referensi.kode;
                this.referensi.keterangan = referensi.keterangan;

                referensi.referensi_detail.forEach((refD, index) => {
                    refD.readonly = true;
                });

                this.referensi_detail = referensi.referensi_detail;
            },

            addDetail(){
                this.referensi_detail.push({
                    id: "",
                    key: "",
                    val: "",
                    keterangan: "",
                    readonly: false
                });
            },

            deleteDetail(index){
                if (this.referensi_detail[index].id != "") {
                    this.referensi_detail_delete.push(this.referensi_detail[index].id);
                }
                this.referensi_detail.splice(index, 1);
            },

            submit(){

                this.referensi_detail.forEach((refD, index) => {
                    refD.referensi_kode = this.referensi.kode;
                });

                var data = {
                    referensi: this.referensi,
                    referensi_detail: this.referensi_detail,
                    referensi_detail_delete: this.referensi_detail_delete
                }

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

                        var url = "/referensi/store";
                        if(this.mode == "edit"){
                            url = "/referensi/update/";
                        }

                        axios.post(url, data).then(response => {
                            if(response.data == "success"){
                                Swal.close();
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data Berhasil Disimpan',
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

@extends('template-metronics.index')

@section('title')
Form Pameran
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <a v-if="mode == 'view'" :href="'/intervensi/pameran/edit/'+ intervensi.id" class="btn btn-sm btn-info" style="float:right; margin-left:10px"><span class="fa fa-pen"></span> Edit</a>
            <a :href="'/intervensi/pameran'" class="btn btn-sm btn-warning" style="float:right;"><span class="fa fa-arrow-left"></span> Kembali</a>
        </div>
    </div>

    <h3>Pameran / Bazar</h3>
    <hr>
    <form id="form-ref">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Nama Pameran</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi.nama_intervensi" autocomplete="off" type="text" class="form-control" placeholder="Nama pameran">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi.deskripsi" autocomplete="off" type="text" class="form-control" placeholder="Deskripsi pameran">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi.tanggal_mulai" autocomplete="off" type="date" class="form-control">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi.tanggal_selesai" autocomplete="off" type="date" class="form-control">
                </div>
            </div>
        </div>
    </form>
    <h3 style="margin-top:3%">Detail Pameran</h3>
    <hr>
    <button v-if="mode != 'view'" v-on:click="addDetail()" style="margin-bottom: 2%" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Tambah UKM</button>
    <form id="form-detail">
        <table class="table table-bordered" id="table-detail-ref">
            <thead>
                <tr>
                    <th>No</th>
                    <th>UKM</th>
                    <th>Keterangan</th>
                    <th v-if="mode != 'view'">Action</th>
                </tr>
            </thead>
            <tbody>

                <tr v-for="(detail, index) in intervensi_detail" :key="index">
                    <td class="text-center">@{{ index+1 }}</td>
                    <td>
                        <input v-model="detail.nama_ukm" v-on:click="inputUkm(index)" id="input-ukm" class="form-control" type="text" readonly placeholder="Klik Disini" />
                    </td>
                    <td>
                        <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="detail.keterangan" type="text" class="form-control" />
                    </td>
                    <td v-if="mode != 'view'" class="text-center">
                        <button type="button" v-on:click="deleteDetail(detail, index)" class="btn btn-sm btn-danger btn-delete-ref"><span class="fa fa-trash"></span></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </form>

    <div v-if="mode != 'view'">
        <h3 style="margin-top:3%">Simpan Data pameran</h3>
        <hr>

        <button v-on:click="submit()" type="button" class="btn btn-success btn-sm"><span class="fa fa-check"></span> Simpan</button>
    </div>

    <div id="modal-ukm" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih UKM</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <div class="modal-body">
                    <table id="table-ukm" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Pemilik</th>
                            <th>NIK</th>
                            <th>No Telpon</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tr v-for="(ukm, index) in dataUkm" :key="index">
                            <td>@{{ ukm.nama_ukm }}</td>
                            <td>@{{ ukm.nama_pemilik }}</td>
                            <td>@{{ ukm.nik }}</td>
                            <td>@{{ ukm.no_telp }}</td>
                            <td>@{{ ukm.alamat }}</td>
                            <td><button v-on:click="selectUkm(index)" class="btn btn-sm btn-success"><span class="fa fa-check"></span></button></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

<script>

Vue.directive('select', {
    twoWay: true,
    bind: function (el, binding, vnode) {
        $(el).select2().on("select2:select", (e) => {
            el.dispatchEvent(new Event('change', { target: e.target }));
        });
    },
});
var app = new Vue({
        el: '#app',
        data: {
            api:{
                "dataUkm": "/api/ukm"
            },
            intervensi: {
                jenis_intervensi: "pameran",
                nama_intervensi: "",
                deskripsi: "",
                tanggal_mulai: "",
                tanggal_selesai: ""
            },
            intervensi_detail: [
                {
                    ukm_id: "",
                    nama_ukm: "",
                    intervensi_id: "",
                    keterangan: "",
                    readonly: false
                }
            ],
            selectedDetail: "",
            dataUkm: [],
            intervensi_detail_delete: [],
            mode: <?= json_encode($mode); ?>,
            intervensi_detail_delete: []
        },

        mounted(){
            $("#jenisIntervensi").select2({
                placeholder: "Pilih Jenis Intervensi"
            });

            this.getUkm();

            if(this.mode == 'edit' || this.mode == 'view'){
                this.initDataEdit();
            }
        },

        methods: {

            initDataEdit(){
                var data = <?= json_encode($intervensi); ?>;
                var tanggal_mulai = new Date(data.tanggal_mulai);
                var tanggal_selesai = new Date(data.tanggal_selesai);
                data.tanggal_mulai = tanggal_mulai.toString("yyyy-MM-dd");
                data.tanggal_selesai = tanggal_selesai.toString("yyyy-MM-dd");

                this.intervensi = data;

                this.intervensi_detail = this.intervensi.intervensi_detail;
            },

            addDetail(){
                this.intervensi_detail.push(
                    {
                        id: "",
                        ukm_id: "",
                        intervensi_id: "",
                        keterangan: "",
                        tanggal: "",
                        readonly: false
                    }
                )
            },

            async getUkm(){
                const response = await axios(this.api.dataUkm);
                this.dataUkm = response.data;

                setTimeout(() => {
                    $("#table-ukm").DataTable();
                }, 300);
            },

            inputUkm(indexDetail){
                if (this.mode != 'view') {
                    $("#modal-ukm").modal("show");
                    this.selectedDetail = indexDetail;
                }
            },

            selectUkm(index){
                this.intervensi_detail[this.selectedDetail].ukm_id = this.dataUkm[index].id;
                this.intervensi_detail[this.selectedDetail].nama_ukm = this.dataUkm[index].nama_ukm;
                $("#modal-ukm").modal("hide");

                this.$forceUpdate();
            },

            deleteDetail(intervensi, index){

                if(intervensi.id != ""){
                    this.intervensi_detail_delete.push(intervensi.id);
                }

                this.intervensi_detail.splice(index, 1);
            },

            submit(){

                var data = {
                    intervensi: this.intervensi,
                    intervensi_detail: this.intervensi_detail,
                    intervensi_detail_delete: this.intervensi_detail_delete
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

                        var url = "/intervensi/pameran/store";
                        if(this.mode == "edit"){
                            url = "/intervensi/pameran/update";
                        }

                        axios.post(url, data).then(response => {
                            if(response.data == "sukses"){
                                Swal.close();
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data Berhasil Disimpan',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                window.location = "/intervensi/pameran";
                            }
                        });
                    }
                });
            }
        },
});

</script>

@endsection

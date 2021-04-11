@extends('template-metronics.index')

@section('title')
Form Sertifikasi Merek
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <a v-if="mode == 'view'" :href="'/intervensi/merek/edit/'+ intervensi.id" class="btn btn-sm btn-info" style="float:right; margin-left:10px"><span class="fa fa-pen"></span> Edit</a>
            <a :href="'/intervensi/SertifikasiMerek'" class="btn btn-sm btn-warning" style="float:right;"><span class="fa fa-arrow-left"></span> Kembali</a>
        </div>
    </div>

    <h3>Pengajuan Sertifikasi Merek</h3>
    <hr>
    <form id="form-ref">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label>UKM</label>
                    <input v-model="intervensi_detail.nama_usaha" v-on:click="inputUkm()" id="input-ukm" class="form-control" type="text" readonly placeholder="Klik Disini" />
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Nama Merek</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi_detail.nama_merek" autocomplete="off" type="text" class="form-control" placeholder="Nama Merek">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Permohonan</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi_detail.no_permohonan" autocomplete="off" type="text" class="form-control" placeholder="No. Permohonan">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label>Tanggal Penerimaan Berkas di Kemenkumham</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi_detail.tgl_berkas_kemenkumham" autocomplete="off" type="date" class="form-control">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" v-model="intervensi_detail.status">
                        <option selected value="didaftar">Didaftar</option>
                        <option value="proses_cetak">Proses Cetak</option>
                        <option value="menunggu_tanggapan">Menunggu Tanggapan</option>
                        <option value="sudah_keluar_sertifikat">Sudah Keluar Sertifikat</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>
            <div class="col-4" v-if="intervensi_detail.status == 'sudah_keluar_sertifikat'">
                <div class="form-group">
                    <label>No Sertifikat</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi_detail.no_sertifikat" autocomplete="off" type="text" class="form-control" placeholder="Nomor Sertifikat">
                </div>
            </div>
            <div class="col-4" v-if="intervensi_detail.status == 'sudah_keluar_sertifikat'">
                <div class="form-group">
                    <label>Tanggal Sertifikat</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi_detail.tgl_sertifikat" type="date" class="form-control">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Keterangan</label>
                    <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="intervensi_detail.keterangan" autocomplete="off" type="text" class="form-control" placeholder="Keterangan">
                </div>
            </div>
        </div>
    </form>

    <div v-if="mode != 'view'">
        <button style="float:right" v-on:click="submit()" type="button" class="btn btn-success btn-sm"><span class="fa fa-check"></span> Simpan</button>
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
                            <td>@{{ ukm.nama_usaha }}</td>
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
            intervensi_detail: {
                ukm_id: "",
                nama_usaha: "",
                keterangan: "",
                no_permohonan: "",
                nama_merek: "",
                tgl_berkas_kemenkumham: "",
                status: "",
                no_sertifikat: "",
                tgl_sertifikat: ""
            },
            dataUkm: [],
            mode: <?= json_encode($mode); ?>
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

                this.intervensi_detail = data[0];

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
                this.intervensi_detail.ukm_id = this.dataUkm[index].id;
                this.intervensi_detail.nama_usaha = this.dataUkm[index].nama_usaha;
                $("#modal-ukm").modal("hide");

                this.$forceUpdate();
            },

            submit(){

                var data = {
                    intervensi_detail: this.intervensi_detail
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

                        var url = "/intervensi/SertifikasiMerek/store";
                        if(this.mode == "edit"){
                            url = "/intervensi/SertifikasiMerek/update";
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
                                window.location = "/intervensi/SertifikasiMerek";
                            }
                        });
                    }
                });
            }
        },
});

</script>

@endsection

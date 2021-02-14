@extends('template-metronics.index')

@section('title')
Intervensi
@endsection

@section('content')

    <div v-if="mode == 'view'" class="row">
        <div class="col-12">
            <a :href="'/intervensi/edit/'+ intervensi.kode" class="btn btn-sm btn-info" style="float:right; margin-left:10px"><span class="fa fa-pen"></span> Edit</a>
            <a :href="'/intervensi'" class="btn btn-sm btn-warning" style="float:right;"><span class="fa fa-arrow-left"></span> Kembali</a>
        </div>
    </div>

    <h3>Intervensi</h3>
    <hr>
    <form id="form-ref">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Jenis Intervensi</label>
                    <select v-model="intervensi.jenis_intervensi" v-select="intervensi.jenis_intervensi" class="form-control" id="jenisIntervensi" name="param">
                        <option value="AK">Alaska</option>
                        <option value="HI">Hawaii</option>
                        <option value="CA">California</option>
                        <option value="NV">Nevada</option>
                        <option value="OR">Oregon</option>
                        <option value="WA">Washington</option>
                        <option value="AZ">Arizona</option>
                        <option value="CO">Colorado</option>
                        <option value="ID">Idaho</option>
                        <option value="MT">Montana</option>
                        <option value="NE">Nebraska</option>
                        <option value="NM">New Mexico</option>
                        <option value="ND">North Dakota</option>
                        <option value="UT">Utah</option>
                        <option value="WY">Wyoming</option>
                        <option value="AL">Alabama</option>
                        <option value="AR">Arkansas</option>
                        <option value="IL">Illinois</option>
                        <option value="IA">Iowa</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="MN">Minnesota</option>
                        <option value="MS">Mississippi</option>
                        <option value="MO">Missouri</option>
                        <option value="OK">Oklahoma</option>
                        <option value="SD">South Dakota</option>
                        <option value="TX">Texas</option>
                        <option value="TN">Tennessee</option>
                        <option value="WI">Wisconsin</option>
                        <option value="CT">Connecticut</option>
                        <option value="DE">Delaware</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="IN">Indiana</option>
                        <option value="ME">Maine</option>
                        <option value="MD">Maryland</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MI">Michigan</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NY">New York</option>
                        <option value="NC">North Carolina</option>
                        <option value="OH">Ohio</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="VT">Vermont</option>
                        <option value="VA">Virginia</option>
                        <option value="WV">West Virginia</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Nama Intervensi</label>
                    <input v-model="intervensi.nama_intervensi" autocomplete="off" type="text" class="form-control" placeholder="Nama Intervensi">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input v-model="intervensi.deskripsi" autocomplete="off" type="text" class="form-control" placeholder="Nama Intervensi">
                </div>
            </div>
        </div>
    </form>
    <h3 style="margin-top:3%">Detail intervensi</h3>
    <hr>
    <button v-if="mode != 'view'" v-on:click="addDetail()" style="margin-bottom: 2%" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Tambah</button>
    <form id="form-detail">
        <table class="table table-bordered" id="table-detail-ref">
            <thead>
                <tr>
                    <th>No</th>
                    <th>UKM</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                <tr v-for="(detail, index) in intervensi_detail" :key="index">
                    <td class="text-center">@{{ index+1 }}</td>
                    <td>
                        <input v-model="detail.nama_ukm" v-on:click="inputUkm(index)" id="input-ukm" class="form-control" type="text" readonly placeholder="Klik Disini" />
                    </td>
                    <td>
                        <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="detail.tanggal" type="date" class="form-control" />
                    </td>
                    <td>
                        <input {{ $mode == 'view' ? 'readonly' : '' }} v-model="detail.keterangan" type="text" class="form-control" />
                    </td>
                    <td class="text-center">
                        <button type="button" v-on:click="deleteDetail(index)" class="btn btn-sm btn-danger btn-delete-ref"><span class="fa fa-trash"></span></button>
                    </td>
                </tr>

            </tbody>
        </table>
    </form>

    <div v-if="mode != 'view'">
        <h3 style="margin-top:3%">Simpan Data intervensi</h3>
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
            intervensi:{
                jenis_intervensi: "Alaska",
                nama_intervensi: ""
            },
            intervensi_detail: [
                {
                    id_ukm: "",
                    nama_ukm: "",
                    id_intervensi: "",
                    deskripsi: "",
                    tanggal: "",
                    readonly: false
                }
            ],
            selectedDetail: "",
            dataUkm: [],
            intervensi_detail_delete: [],
            mode: <?= json_encode($mode); ?>
        },

        mounted(){
            $("#jenisIntervensi").select2({
                placeholder: "Pilih Jenis Intervensi"
            });

            this.getUkm();
        },

        methods: {
            addDetail(){
                this.intervensi_detail.push(
                    {
                        id_ukm: "",
                        id_intervensi: "",
                        deskripsi: "",
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
                $("#modal-ukm").modal("show");
                this.selectedDetail = indexDetail;
            },

            selectUkm(index){
                this.intervensi_detail[this.selectedDetail].id_ukm = this.dataUkm[index].id;
                this.intervensi_detail[this.selectedDetail].nama_ukm = this.dataUkm[index].nama_ukm;
                $("#modal-ukm").modal("hide");

                this.$forceUpdate();
            }
        },
});

</script>

@endsection

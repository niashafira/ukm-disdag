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
                intervensiDetail: "/intervensi/getIntervensiDetail",
                export: "/intervensi/pelatihan/export"
            },
            intervensi: {
                jenis_intervensi: "pelatihan",
                nama_intervensi: "",
                deskripsi: "",
                lokasi: "",
                tanggal_mulai: "",
                tanggal_selesai: ""
            },
            intervensi_detail: [],
            field_ukm:[
                {
                    key: "nama_usaha",
                    value: "Nama UKM",
                    checked: true
                },
                {
                    key: "nama_pemilik",
                    value: "Nama Pemilik",
                    checked: false
                },
                {
                    key: "nik",
                    value: "NIK",
                    checked: false
                },
                {
                    key: "alamat",
                    value: "Alamat",
                    checked: false
                },
                {
                    key: "no_telp",
                    value: "Nomor Telpon",
                    checked: false
                },
                {
                    key: "jangkauan_pemasaran",
                    value: "Jangkauan Pemasaran",
                    checked: false
                },
                {
                    key: "email",
                    value: "Email",
                    checked: false
                },
                {
                    key: "no_siup",
                    value: "No SIUP",
                    checked: false
                },
                {
                    key: "no_nib",
                    value: "No NIB",
                    checked: false
                },
                {
                    key: "no_iumk",
                    value: "No IUMK",
                    checked: false
                },
                {
                    key: "no_pirt",
                    value: "No PIRT",
                    checked: false
                },
                {
                    key: "no_bpom",
                    value: "No BPOM",
                    checked: false
                },
                {
                    key: "jenis_produksi",
                    value: "Jenis Produk",
                    checked: false
                },
                {
                    key: "tahun_binaan",
                    value: "Tahun Binaan",
                    checked: false
                },
                {
                    key: "status",
                    value: "Status",
                    checked: false
                },
                {
                    key: "npwp",
                    value: "NPWP",
                    checked: false
                }
            ],
            semua: false
        },

        mounted(){
            this.initData();
        },

        methods: {

            initData(){
                var data = <?= json_encode($intervensi); ?>;
                data.tanggal_mulai = new Date(data.tanggal_mulai).toString('dd MMMM yyyy');
                data.tanggal_selesai = new Date(data.tanggal_selesai).toString('dd MMMM yyyy');

                this.intervensi = data;

                this.getIntervensiDetail();
            },

            async getIntervensiDetail(){
                const response = await axios(this.api.intervensiDetail + "?intervensiId=" + this.intervensi.id);

                if(response.data.status == "S"){
                    this.intervensi_detail = response.data.data;

                    setTimeout(() => {
                        $("#table-peserta").DataTable();
                    }, 500);
                }

            },

            checkAll(){
                let status = false;
                if(this.semua == false){
                    status = true;
                }
                this.field_ukm.forEach((field, index) => {
                    if(field.key != "nama_usaha"){
                        field.checked = status;
                    }
                });
            },

            checkField(){
                let status = true
                for (let i = 0; i < this.field_ukm.length; i++) {
                    if(this.field_ukm[i].checked == false){
                        status = false;
                    }
                }

                this.semua = status;
            },

            openModalExport(){
                $("#modal-export").modal("show");
            },

            async submitExport(){
                Swal.fire({
                    title: 'Mohon Tunggu !',
                    html: '',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
                let checkedField = [];
                this.field_ukm.forEach((field, index) => {
                    if(field.checked == true){
                        checkedField.push(field);
                    }
                });

                let data = {
                    id: this.intervensi.id,
                    field: checkedField
                }

                const response = await axios.post(this.api.export, data);

                if(response.data.status == "S"){
                    var linkSource = response.data.excel;
                    var downloadLink = document.createElement("a");
                    var fileName = this.intervensi.nama_intervensi + '.xlsx';

                    downloadLink.href = linkSource;
                    downloadLink.download = fileName;
                    downloadLink.click();

                    Swal.close();
                }
            }
        },
    });

</script>

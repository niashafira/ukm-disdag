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
                dataUkm: "/api/ukm",
                create: "/intervensi/SertifikasiMerek/store",
                update: "/intervensi/SertifikasiMerek/update",
                validate: "/intervensi/SertifikasiMerek/validate"
            },
            dataUkm: [],
            intervensi: {},
            validation: {},
            mode: "",
            nama_usaha: ""

        },

        mounted(){
            this.mode = {!! json_encode($mode) !!};
            if(this.mode != 'create') this.initData();
            this.setValidation();
        },

        methods: {
            initData(){
                this.intervensi = {!! json_encode($intervensi) !!};
                this.nama_usaha = this.intervensi.nama_usaha;
                delete this.intervensi['nama_usaha'];
                this.intervensi.tgl_pendaftaran = new Date(this.intervensi.tgl_pendaftaran).toString('yyyy-MM-dd');
                if(this.intervensi.tgl_berkas_kemenkumham != undefined) this.intervensi.tgl_berkas_kemenkumham = new Date(this.intervensi.tgl_berkas_kemenkumham).toString('yyyy-MM-dd');
                if(this.intervensi.tgl_sertifikat != undefined) this.intervensi.tgl_sertifikat = new Date(this.intervensi.tgl_sertifikat).toString('yyyy-MM-dd');
            },

            changeStatus(){
                delete this.intervensi['tgl_sertifikat'];
                delete this.intervensi['no_sertifikat'];
            },

            openModalUkm(){
                getUkm();
                $("#modal-ukm").modal("show");
            },

            async validateUkm(id){
                const response = await axios.get(api.validate + '?id=' + id);
                if(response.data.status != 'S') return false;
            },

            async save(){
                this.validation.validate().then(async (status) => {
                    if (status == 'Valid') {
                        Swal.fire({
                            title: 'Apakah anda yakin ?',
                            text: "",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya'
                            }).then(async (result) => {
                            if (result.isConfirmed) {
                                showLoading();

                                let data = {
                                    intervensi: this.intervensi
                                };

                                let url = this.api.create;
                                if(this.mode == 'edit') url = this.api.update;

                                const response = await axios.post(url, data);
                                Swal.close();

                                if(response.data.status == "S"){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    window.location = "/intervensi/SertifikasiMerek";
                                }
                                else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '',
                                        text: response.data.message
                                    });
                                }
                            }
                        });

                    }
                });
            },

            setValidation(){
                this.validation = FormValidation.formValidation(
                    document.getElementById('form-intervensi'),
                    {
                        fields: {
                            nama_usaha: {
                                validators: {
                                    notEmpty: {
                                        message: 'Nama UKM tidak boleh kosong'
                                    }
                                }
                            },
                            nama_merek: {
                                validators: {
                                    notEmpty: {
                                        message: 'Nama Merek tidak boleh kosong'
                                    }
                                }
                            },
                            tgl_pendaftaran: {
                                validators: {
                                    notEmpty: {
                                        message: 'Tanggal pendaftaran tidak boleh kosong'
                                    }
                                }
                            },
                            status: {
                                validators: {
                                    notEmpty: {
                                        message: 'Status tidak boleh kosong'
                                    }
                                }
                            },
                            tgl_sertifikat: {
                                validators: {
                                    notEmpty: {
                                        message: 'Tanggal sertifikat tidak boleh kosong'
                                    }
                                }
                            },
                            no_sertifikat: {
                                validators: {
                                    notEmpty: {
                                        message: 'No sertifikat tidak boleh kosong'
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap({
                                eleValidClass: '',
                            })
                        }
                    }
                );
            }
        }
    });

    function selectUkm(nama_usaha, nama_pemilik, nik, alamat, id){
        app.intervensi.ukm_id = id;
        app.nama_usaha = nama_usaha;

        $("#modal-ukm").modal("hide");
    }

</script>

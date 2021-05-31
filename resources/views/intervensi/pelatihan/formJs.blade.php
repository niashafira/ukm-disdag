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
                create: "/intervensi/create"
            },
            peserta: [],
            dataUkm: [],
            intervensi: {
                jenis_intervensi: 'pelatihan'
            },
            intervensiDetail: [],
            validation: {}

        },

        mounted(){
            this.setValidation();
        },

        methods: {
            openModalUkm(){
                getUkm();
                $("#modal-ukm").modal("show");
            },

            deletePeserta(id){
                for (let i = 0; i < this.peserta.length; i++) {
                    if(this.peserta[i].id == id) {
                        this.peserta.splice(i, 1);
                        return false;
                    }
                }
            },

            checkDuplicatePeserta(id){
                for (let i = 0; i < this.peserta.length; i++) {
                    if(this.peserta[i].id == id) return true
                }

                return false;
            },

            async simpan(){
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
                                    intervensi: this.intervensi,
                                    intervensiDetail: []
                                };

                                this.peserta.forEach((p, index) => {
                                    data.intervensiDetail.push({
                                        ukm_id: p.id,
                                        keterangan: p.keterangan
                                    });
                                });

                                const response = await axios.post(this.api.create, data);
                                Swal.close();

                                if(response.data.status == "S"){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: response.data.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                    window.location = "/intervensi/pelatihan";
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
                            nama_intervensi: {
                                validators: {
                                    notEmpty: {
                                        message: 'Nama tidak boleh kosong'
                                    }
                                }
                            },
                            lokasi: {
                                validators: {
                                    notEmpty: {
                                        message: 'Lokasi tidak boleh kosong'
                                    }
                                }
                            },
                            tanggal_mulai: {
                                validators: {
                                    notEmpty: {
                                        message: 'Tanggal mulai tidak boleh kosong'
                                    }
                                }
                            },
                            tanggal_selesai: {
                                validators: {
                                    notEmpty: {
                                        message: 'Tanggal selesai tidak boleh kosong'
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
        if(app.checkDuplicatePeserta(id)){
            Swal.fire({
                icon: 'error',
                title: '',
                text: "UKM telah terdaftar"
            });
        }
        else{
            app.peserta.push({
                nama_usaha: nama_usaha,
                nama_pemilik: nama_pemilik,
                nik: nik,
                alamat: alamat,
                id: id,
                keterangan: ""
            });
            $("#modal-ukm").modal("hide");
        }
    }

</script>

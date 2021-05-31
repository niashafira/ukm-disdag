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
                create: "/intervensi/create",
                update: "/intervensi/update",
                intervensiDetail: "/intervensi/getIntervensiDetail"
            },
            intervensiDetail: [],
            intervensiDetailDelete: [],
            dataUkm: [],
            intervensi: {
                jenis_intervensi: 'pelatihan'
            },
            validation: {},
            mode: ""

        },

        mounted(){
            this.mode = {!! json_encode($mode) !!};
            this.setValidation();

            if(this.mode == 'edit') this.initData();
        },

        methods: {

            initData(){
                this.intervensi = {!! json_encode($intervensi) !!};
                this.intervensi.tanggal_mulai = new Date(this.intervensi.tanggal_mulai).toString('yyyy-MM-dd');
                this.intervensi.tanggal_selesai = new Date(this.intervensi.tanggal_selesai).toString('yyyy-MM-dd');

                this.getIntervensiDetail();
            },

            async getIntervensiDetail(){
                const response = await axios(this.api.intervensiDetail + "?intervensiId=" + this.intervensi.id);

                if(response.data.status == "S"){
                    this.intervensiDetail = response.data.data;
                }

            },

            openModalUkm(){
                getUkm();
                $("#modal-ukm").modal("show");
            },

            deleteintervensiDetail(ukm, index){
                if(ukm.id != undefined) this.intervensiDetailDelete.push(ukm.id);
                this.intervensiDetail.splice(index, 1);
            },

            checkDuplicateintervensiDetail(id){
                for (let i = 0; i < this.intervensiDetail.length; i++) {
                    if(this.intervensiDetail[i].id == id) return true
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
                                    intervensiDetail: this.intervensiDetail,
                                    intervensiDetailDelete: this.intervensiDetailDelete
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
        if(app.checkDuplicateintervensiDetail(id)){
            Swal.fire({
                icon: 'error',
                title: '',
                text: "UKM telah terdaftar"
            });
        }
        else{
            app.intervensiDetail.push({
                nama_usaha: nama_usaha,
                nama_pemilik: nama_pemilik,
                nik: nik,
                alamat: alamat,
                ukm_id: id,
                keterangan: ""
            });
            $("#modal-ukm").modal("hide");
        }
    }

</script>

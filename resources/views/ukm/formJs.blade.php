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
                allKecamatan: '/kecamatan/getAll',
                kelurahanByKcmId: '/kelurahan/getByKcmId',
                allKategori: '/kategori/getAll',
                create: '/ukm/create',
                update: '/ukm/update'
            },
            ukm: {},
            dataKecamatan: [],
            kecamatan: {},
            dataKelurahan: [],
            kelurahan: {},
            dataKategori: [],
            validation: {},
            mode: ""

        },

        async mounted(){
            this.mode = {!! json_encode($mode) !!};
            this.setValidation();
            await this.getAllKategori();
            await this.getAllKecamatan();
            if(this.mode == 'edit') this.initData();
        },

        methods: {
            async initData(){
                this.ukm = {!! json_encode($data['profil']) !!};
                this.dataKecamatan.forEach((kecamatan) => {
                    if(kecamatan.kcm_id == this.ukm.kecamatan_id) {
                        this.kecamatan = kecamatan;
                        return false;
                    }
                });
                await this.getKelurahanByKcmId(this.kecamatan.kcm_id);
                this.dataKelurahan.forEach((kelurahan) => {
                    if(kelurahan.klh_id == this.ukm.kelurahan_id) {
                        this.kelurahan = kelurahan;
                        return false;
                    }
                });

                let kategori = {!! json_encode($data['kategori']) !!};
                kategori.forEach((kategori) => {
                    this.dataKategori.forEach((k) => {
                        if(k.nama == kategori.nama) k.active = true
                    })
                });
            },

            async getAllKecamatan(){
                const response = await axios.get(this.api.allKecamatan)
                this.dataKecamatan = response.data.data;
            },

            async getAllKategori(){
                const response = await axios.get(this.api.allKategori)
                this.dataKategori = response.data.data;
                this.dataKategori.forEach((kategori) => {
                    kategori.active = false;
                });
            },

            async getKelurahanByKcmId(kecamatanId){
                Swal.fire({
                    title: 'Mohon Tunggu !',
                    html: '',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });
                this.dataKelurahan = [];
                const response = await axios.get(this.api.kelurahanByKcmId + '?kecamatanId='+kecamatanId);
                this.dataKelurahan = response.data.data;
                Swal.close();
            },

            changeKecamatan(){
                this.getKelurahanByKcmId(this.kecamatan.kcm_id);
            },

            changeKelurahan(){
                this.ukm.kelurahan_id = this.kelurahan.klh_id;
            },

            save(){
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

                                let url = this.api.create;
                                let ukm = this.ukm;
                                if(this.mode == 'edit'){
                                    url = this.api.update;
                                    delete ukm['created_at'];
                                    delete ukm['kecamatan_id'];
                                    delete ukm['nama_kecamatan'];
                                    delete ukm['nama_kelurahan'];
                                    delete ukm['updated_at'];
                                }

                                let data = {
                                    ukm: ukm,
                                    kategoriDetail: []
                                };

                                this.dataKategori.forEach((kategori, index) => {
                                    if(kategori.active == true){
                                        data.kategoriDetail.push({
                                            kategori_id: kategori.id
                                        })
                                    }
                                });

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
                                    window.location = "/ukm/view/" + response.data.data.id;
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
                    else{
                        $("html, body").animate({ scrollTop: 100 }, "slow");
                    }
                });
            },

            setValidation(){
                this.validation = FormValidation.formValidation(
                    document.getElementById('form-ukm'),
                    {
                        fields: {
                            nama_usaha: {
                                validators: {
                                    notEmpty: {
                                        message: 'Nama UKM tidak boleh kosong'
                                    }
                                }
                            },
                            nama_pemilik: {
                                validators: {
                                    notEmpty: {
                                        message: 'Nama Pemilik tidak boleh kosong'
                                    }
                                }
                            },
                            nik: {
                                validators: {
                                    notEmpty: {
                                        message: 'NIK tidak boleh kosong'
                                    }
                                }
                            },
                            no_telp: {
                                validators: {
                                    notEmpty: {
                                        message: 'No Telepon tidak boleh kosong'
                                    }
                                }
                            },
                            alamat: {
                                validators: {
                                    notEmpty: {
                                        message: 'Alamat tidak boleh kosong'
                                    }
                                }
                            },
                            kecamatan: {
                                validators: {
                                    notEmpty: {
                                        message: 'Kecamatan tidak boleh kosong'
                                    }
                                }
                            },
                            kelurahan: {
                                validators: {
                                    notEmpty: {
                                        message: 'Kelurahan tidak boleh kosong'
                                    }
                                }
                            },
                            kategori: {
                                validators: {
                                    notEmpty: {
                                        message: 'Kategori tidak boleh kosong'
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
        },
});

$('#kecamatan').select2({
    placeholder: "Pilih Kecamatan",
    allowClear: true
});

$('#kelurahan').select2({
    placeholder: "Pilih Kelurahan",
    allowClear: true
});
</script>

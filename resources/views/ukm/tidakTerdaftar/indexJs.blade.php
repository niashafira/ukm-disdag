<script>
    var app = new Vue({
        el: '#app',
        data: {
            api: {
                ukmTidakTerdaftar: '/api/ukm/tidakTerdaftar',
                create: '/ukm/sinkron'
            },
            ukm: [],
            selectedUkm: "",
            selectedTargetId: "",
            validation: ""
        },

        mounted(){
            this.getUkmTidakTerdaftar();
            this.setValidation();
        },

        methods: {

            async submitSinkron(){
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
                            intervensi_id: this.selectedUkm.intervensi_id,
                            ukmTidakTerdaftar_id: this.selectedUkm.id,
                            ukm_id: this.selectedTargetId
                        };

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
                            window.location = "/ukm/tidakTerdaftar";
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
            },

            async submitNew(){
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
                                    ukm: {
                                        nama_usaha: this.selectedUkm.nama_usaha,
                                        nama_pemilik: this.selectedUkm.nama_pemilik,
                                        nik: this.selectedUkm.nik,
                                        alamat: this.selectedUkm.alamat,
                                        no_telp: this.selectedUkm.no_telp
                                    },
                                    intervensi_id: this.selectedUkm.intervensi_id,
                                    ukmTidakTerdaftar_id: this.selectedUkm.id
                                };

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
                                    window.location = "/ukm/tidakTerdaftar";
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


            async getUkmTidakTerdaftar(){
                $('#table-ukmTidakTerdaftar').DataTable({
                    processing: true,
                    serverSide: true,
                    destroy: true,
                    order: [[ 1, "desc" ]],
                    ajax: {
                        url: this.api.ukmTidakTerdaftar
                    },
                    language: {
                        processing: "<div style='width: 5rem; height: 5rem;' class='spinner-border' role='status'><span class='sr-only'>Loading...</span></div>",
                    },
                    columns: [
                        {
                            data: null,
                            sortable: false,
                            searchable: false,
                            class: 'text-center',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {data: 'nama_usaha'},
                        {data: 'nama_pemilik'},
                        {data: 'nik'},
                        {data: 'alamat'},
                        {data: 'no_telp'},
                        {data: 'nama_intervensi'},
                        {
                            data: 'null',
                            class: 'text-nowrap text-center',
                            render: function (data, type, row, meta) {
                                let btn = "<button onclick='openModalUkm(\"" + encodeURIComponent(JSON.stringify(row)) + "\")' class='btn btn-sm btn-info'><span class='fa fa-sync'></span> Sinkronkan</button>";
                                btn += "<button onclick='setUkmBaru(\"" + encodeURIComponent(JSON.stringify(row)) + "\")' style='margin-left: 2%' class='btn btn-sm btn-success'><span class='fa fa-save'></span> UKM Baru</button>";
                                return btn;
                            }
                        }
                    ]
                });
            },

            openModalUkmBaru(){
                $("#modal-ukm").modal("hide");
                $("#modal-ukm-baru").modal("show");
            },

            setValidation(){
                this.validation = FormValidation.formValidation(
                    document.getElementById('form-tambah'),
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
                            alamat: {
                                validators: {
                                    notEmpty: {
                                        message: 'Alamat tidak boleh kosong'
                                    }
                                }
                            },
                            no_telp: {
                                validators: {
                                    notEmpty: {
                                        message: 'No telepon tidak boleh kosong'
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

    function openModalUkm(row){
        getUkm();
        app.selectedUkm = JSON.parse(decodeURIComponent(row).replace("&#039;", "'"));
        app.$forceUpdate();
        $("#modal-ukm").modal("show");
    }

    function setUkmBaru(row){
        app.selectedUkm = JSON.parse(decodeURIComponent(row).replace("&#039;", "'"));
        app.$forceUpdate();
        app.openModalUkmBaru();
    }

    function selectUkm(nama_usaha, nama_pemilik, nik, alamat, id){
        app.selectedTargetId = id;
        app.submitSinkron();
    }
</script>

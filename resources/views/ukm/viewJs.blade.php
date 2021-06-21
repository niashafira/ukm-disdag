<script>
    var app = new Vue({
        el: '#app',
        data: {
            api:{
                simpanOmset: "/ukm/omset/store",
                updateOmset: "/ukm/omset/update",
                deleteOmset: "/ukm/omset/delete",
                getOmset: "/ukm/omset/",
                getSertifikasi: "/ukm/sertifikasi/"
            },
            ukm: {},
            kategori: [],
            mainTabs: [
                {
                    nama: "PROFIL & IJIN USAHA",
                    id: "tab-profil",
                    icon: "fa fa-address-card",
                    active: true
                },
                {
                    nama: "OMSET",
                    id: "tab-omset",
                    icon: "fa fa-chart-line",
                    active: false
                },
                {
                    nama: "INTERVENSI",
                    id: "tab-intervensi",
                    icon: "fa fa-clipboard-check",
                    active: false
                }
            ],
            formOmset: {},
            validation: {
                omset: ""
            },
            chartOmset: ""
        },

        async mounted(){
            this.initData();
            $("#link-"+this.mainTabs[0].id).click();
            this.setValidationOmset();
            this.getOmset();
        },

        methods:{

            initData(){
                this.ukm = {!! json_encode($data['profil']) !!};
                this.ukm.intervensi = {!! json_encode($data['intervensi']) !!};
                this.ukm.kategori = {!! json_encode($data['kategori']) !!};
            },

            async getOmset(){
                $("#table-omset").DataTable().destroy();
                var res = await axios.get(this.api.getOmset + this.ukm.id);

                this.ukm.omset = res.data.data;

                this.ukm.omset.forEach((omset, index) => {
                    omset.isEdit = false;
                });

                this.$forceUpdate();

                this.setChartOmset();

                setTimeout( () => {
                    $("#table-omset").DataTable({
                        ordering:  false
                    })
                }, 500);
            },

            async getSertifikasi(){
                var res = await axios.get(this.api.getSertifikasi + this.ukm.profil.id);

                this.sertifikasi = res.data.data;

                this.sertifikasi.merek.forEach((sertifikasi, index) => {
                    sertifikasi.tgl_berkas_kemenkumham = new Date(sertifikasi.tgl_berkas_kemenkumham).toString("dd MMMM yyyy");

                    if(sertifikasi.tgl_sertifikat != undefined){
                        sertifikasi.tgl_sertifikat = new Date(sertifikasi.tgl_sertifikat).toString("dd MMMM yyyy");
                    }

                });

                this.sertifikasi.halal.forEach((sertifikasi, index) => {
                    sertifikasi.tgl_permohonan = new Date(sertifikasi.tgl_permohonan).toString("dd MMMM yyyy");

                    if(sertifikasi.tgl_sertifikat != undefined){
                        sertifikasi.tgl_sertifikat = new Date(sertifikasi.tgl_sertifikat).toString("dd MMMM yyyy");
                    }

                });

            },

            generateChart(){

                var categories = [];
                var values = [];
                for(var i = this.omset.length-1; i >=0; i--){
                    categories.push(new Date(this.omset[i].tanggal).toString("MMM yy"));
                    values.push(this.omset[i].nominal);
                }

                var options = {
                        series: [{
                            name: "Omset",
                            data: values
                        }],
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: true,
                                type: 'x',
                                resetIcon: {
                                    offsetX: -10,
                                    offsetY: 0,
                                    fillColor: '#fff',
                                    strokeColor: '#37474F'
                                },
                                selection: {
                                    background: '#90CAF9',
                                    border: '#0D47A1'
                                }
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'straight'
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: categories,
                        }
                    };

                    this.chartOmset = new ApexCharts(document.querySelector("#chartOmset"), options);
                    this.chartOmset.render();
            },

            resetChartOmset(){
                this.chartOmset.destroy();
                this.generateChart();
            },

            openModalOmset(){
                $("#modal-omset").modal("show");
            },

            tambahOmset(){
                this.newOmset = {
                    tanggal: "",
                    nominal: "",
                    jml_produk_terjual: "",
                    keterangan: "",
                    ukm_id: this.ukm.profil.id
                };
            },

            async simpanOmset(omset){
                this.validation.omset.validate().then(async (status) => {
                    if (status == 'Valid') {
                        showLoading();
                    }
                });

                this.formOmset.ukm_id = this.ukm.id;
                var data = {
                    omset: this.formOmset
                }

                const response = await axios.post(this.api.simpanOmset, data);
                Swal.close();

                if (response.data.status == "S") {
                    this.getOmset();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data Berhasil Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: response.data.message,
                    });
                }

            },

            editOmset(omset){
                omset.isEdit = true;

                this.$forceUpdate();
            },

            async updateOmset(omset){
                showLoading();

                var data = {
                    omset: {
                        id: omset.id,
                        ukm_id: omset.ukm_id,
                        nominal: omset.nominal,
                        jml_produk_terjual: omset.jml_produk_terjual
                    }
                }

                const response = await axios.post(this.api.updateOmset, data);

                Swal.close();

                if (response.data.status == "S"){
                    omset.isEdit = false;
                    this.getOmset();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: response.data.message,
                    });
                }
            },

            async deleteOmset(id){
                showLoading();
                const response = await axios.delete(this.api.deleteOmset + '/' + id);
                Swal.close();
                if (response.data.status == "S"){
                    this.getOmset();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                else{
                    Swal.fire({
                        icon: 'error',
                        title: response.data.message,
                    });
                }
            },

            setValidationOmset(){
                this.validation.omset = FormValidation.formValidation(
                    document.getElementById('form-omset'),
                    {
                        fields: {
                            bulan: {
                                validators: {
                                    notEmpty: {
                                        message: 'Bulan tidak boleh kosong'
                                    }
                                }
                            },
                            jml_terjual: {
                                validators: {
                                    notEmpty: {
                                        message: 'Jumlah terjual tidak boleh kosong'
                                    }
                                }
                            },
                            omset: {
                                validators: {
                                    notEmpty: {
                                        message: 'Omset tidak boleh kosong'
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
            },

            setChartOmset(){
                let labels = [];
                let dataSet = [];
                this.ukm.omset.forEach((omset, index) => {
                    labels.unshift(new Date(omset.tanggal).toString('MMMM yyyy'));
                    dataSet.unshift(omset.nominal);
                });

                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Omset',
                        data: dataSet,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                };

                const config = {
                    type: 'line',
                    data: data,
                };

                var ctx = document.getElementById('chart-omset');
                if(this.chartOmset != "") this.chartOmset.destroy();
                this.chartOmset = new Chart(ctx, config);
            }
        }
    });

</script>

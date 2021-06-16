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
            intervensi: {},
            omset: [],
            kategori: [],
            newOmset: "",
            chartOmset: {},
            sertifikasi: [],
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
            ]
        },

        mounted(){
            this.initData();
            $("#link-"+this.mainTabs[0].id).click();
        },

        methods:{

            initData(){
                this.ukm = {!! json_encode($data['profil']) !!};
                this.ukm.intervensi = {!! json_encode($data['intervensi']) !!};
                this.ukm.kategori = {!! json_encode($data['kategori']) !!};
            },

            async getOmset(){
                var res = await axios.get(this.api.getOmset + this.ukm.profil.id);

                this.omset = res.data.data;

                this.omset.forEach((omset, index) => {
                    omset.isEdit = false;
                });

                this.generateChart();
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

            simpanOmset(omset){
                Swal.fire({
                    title: 'Mohon Tunggu !',
                    html: '',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });

                var data = {
                    omset: this.newOmset
                }

                axios.post(this.api.simpanOmset, data).then(response => {
                    if(response.data.status == "S"){
                        Swal.close();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Berhasil Disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        response.data.data.isEdit = false;

                        this.omset.unshift(response.data.data);

                        this.newOmset = "";

                        this.$forceUpdate();

                        this.resetChartOmset();

                    }
                });
            },

            editOmset(omset){
                omset.isEdit = true;

                this.$forceUpdate();
            },

            updateOmset(omset){
                Swal.fire({
                    title: 'Mohon Tunggu !',
                    html: '',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });

                var data = {
                    omset: omset
                }

                axios.post(this.api.updateOmset, data).then(response => {
                    if(response.data.status == "S"){
                        Swal.close();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Berhasil Disimpan',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        omset.isEdit = false;

                        this.resetChartOmset();

                        this.$forceUpdate();

                    }
                });
            },

            deleteOmset(omset, index){
                Swal.fire({
                    title: 'Mohon Tunggu !',
                    html: '',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    },
                });

                var data = {
                    omset: omset
                }

                axios.post(this.api.deleteOmset, data).then(response => {
                    if(response.data.status == "S"){
                        Swal.close();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Berhasil Dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        this.omset.splice(index, 1);

                        this.resetChartOmset();

                        this.$forceUpdate();

                    }
                });
            }
        }
    });

</script>

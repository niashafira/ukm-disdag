<script>
var app = new Vue({
    el: '#app',
    data: {
        url:{
            filter: "/monitoring/filter",
            exportExcel: "/monitoring/exportExcel"
        },

        jenis_intervensi:[
            {
                key: "semua",
                jenis: "Semua",
                checked: true
            },
            {
                key: "pelatihan",
                jenis: "Pelatihan",
                checked: true
            },
            {
                key: "merek",
                jenis: "Sertifikasi Merek",
                checked: true
            },
            {
                key: "pemasaran",
                jenis: "Pemasaran",
                checked: true
            },
            {
                key: "halal",
                jenis: "Sertifikasi Halal",
                checked: true
            },
            {
                key: "pameran",
                jenis: "Pameran / Bazar",
                checked: true
            }
        ],
        tanggal_mulai: "2017-01-01",
        tanggal_selesai: "2021-06-05",
        kata_kunci: "",
        dataIntervensi: [],
        dataIntervensiCount: 0,
        intervenProp: {
            offset: 0,
            noStart: 0,
            noEnd: 0
        },
        filterHalal:{
            offset: 0,
            noStart: 0,
            noEnd: 0
        },
        filterMerek:{
            offset: 0,
            noStart: 0,
            noEnd: 0
        },
        filterPelatihan:{
            offset: 0,
            noStart: 0,
            noEnd: 0
        },
        filterPameran:{
            offset: 0,
            noStart: 0,
            noEnd: 0
        },
        filterPemasaran:{
            offset: 0,
            noStart: 0,
            noEnd: 0
        },
        dataHalal: [],
        dataHalalCount: "",
        dataMerek: [],
        dataMerekCount: "",
        dataPelatihan: [],
        dataPelatihanCount: "",
        dataPameran: [],
        dataPameranCount: "",
        dataPemasaran: [],
        dataPemasaranCount: ""
    },

    async mounted(){
        await this.submitFilter('new');
        this.setPaginataion();
    },

    methods: {
        onChangeIntervensi(jenis){
            if(jenis.jenis == "Semua"){
                if(jenis.checked == true){
                    this.jenis_intervensi.forEach((j) => {
                        j.checked = true;
                    })
                }
                if(jenis.checked == false){
                    this.jenis_intervensi.forEach((j) => {
                        j.checked = false;
                    })
                }
            }
            else{
                this.jenis_intervensi.forEach((j) => {
                    if(j.checked == false){
                        this.jenis_intervensi[0].checked = false;
                    }
                })
            }

            this.$forceUpdate();

        },

        async submitFilter(type){
            if(type == 'new'){
                this.intervenProp.offset = 0;
            }
            var checked_jenis = [];
            for (let i = 1; i < this.jenis_intervensi.length; i++) {
                if(this.jenis_intervensi[i].checked == true){
                    checked_jenis.push(this.jenis_intervensi[i]);
                }

            }

            if(checked_jenis.length == 0){
                alert("Jenis Intervensi tidak boleh kosong");
            }
            else{
                var data = {
                    jenis_intervensi: checked_jenis,
                    tanggal_mulai: this.tanggal_mulai,
                    tanggal_selesai: this.tanggal_selesai,
                    kata_kunci: this.kata_kunci,
                    offset: this.intervenProp.offset,
                    pelatihan:{
                        offset: this.filterPelatihan.offset,
                        checked: this.jenis_intervensi[1].checked
                    },
                    pameran:{
                        offset: this.filterPameran.offset,
                        checked: this.jenis_intervensi[5].checked
                    },
                    pemasaran:{
                        offset: this.filterPemasaran.offset,
                        checked: this.jenis_intervensi[3].checked
                    },
                    halal: {
                        offset: this.filterHalal.offset,
                        checked: this.jenis_intervensi[4].checked
                    },
                    merek: {
                        offset: this.filterMerek.offset,
                        checked: this.jenis_intervensi[2].checked
                    }
                };

                const response = await axios.post(this.url.filter, data);
                if(response.data.status == "S"){

                    if(response.data.data.length > 0){
                        this.dataIntervensi = response.data.data;
                        this.dataIntervensiCount = response.data.count[0].count;
                        this.dataIntervensi.forEach((intervensi) => {
                            if(intervensi.tanggal_mulai != undefined){
                                intervensi.tanggal_mulai = new Date(intervensi.tanggal_mulai).toString("dd MMMM yyyy");
                            }
                            if(intervensi.tanggal_selesai != undefined){
                                intervensi.tanggal_selesai = new Date(intervensi.tanggal_selesai).toString("dd MMMM yyyy");
                            }
                        });
                        this.intervenProp.noStart = this.intervenProp.offset + 1;
                        this.intervenProp.noEnd = this.intervenProp.offset + this.dataIntervensi.length;
                    }
                    else{
                        this.this.intervenProp.offset = 0;
                        this.intervenProp.noStart = 0;
                        this.intervenProp.noEnd = 0;
                        this.dataIntervensiCount = 0;
                        this.dataIntervensi = [];
                    }

                    //SERTIFIKASI HALAL
                    if(response.data.halal.length > 0){
                        this.dataHalal = response.data.halal;
                        this.dataHalal.forEach((halal, index) => {
                            halal.tgl_permohonan = new Date(halal.tgl_permohonan).toString("dd MMMM yyyy");

                            if(halal.tgl_sertifikat != undefined){
                                halal.tgl_sertifikat = new Date(halal.tgl_sertifikat).toString("dd MMMM yyyy");
                            }

                            if(halal.status == "ditolak"){
                                halal.status = "Ditolak"
                            }
                            else if(halal.status == "proses_cetak"){
                                halal.status = "Menunggu Proses Cetak"
                            }
                            else if(halal.status == "menunggu_tanggapan"){
                                halal.status = "Menunggu Tanggapan"
                            }
                            else if(halal.status == "sudah_keluar_sertifikat"){
                                halal.status = "Sudah Keluar Sertifikat"
                            }
                        });
                        this.dataHalalCount = response.data.count_halal[0].count;
                        this.filterHalal.noStart = this.filterHalal.offset + 1;
                        this.filterHalal.noEnd = this.filterHalal.offset + this.dataHalal.length;
                    }
                    else{
                        this.filterHalal.offset = 0;
                        this.filterHalal.noStart = 0;
                        this.filterHalal.noEnd = 0;
                        this.dataHalalCount = 0;
                        this.dataHalal = [];
                    }

                    //SERTIFIKASI MEREK
                    if(response.data.merek.length > 0){
                        this.dataMerek = response.data.merek;
                        this.dataMerek.forEach((merek, index) => {
                            merek.tgl_berkas_kemenkumham = new Date(merek.tgl_berkas_kemenkumham).toString("dd MMMM yyyy");

                            if(merek.tgl_sertifikat != undefined){
                                merek.tgl_sertifikat = new Date(merek.tgl_sertifikat).toString("dd MMMM yyyy");
                            }

                            if(merek.status == "ditolak"){
                                merek.status = "Ditolak"
                            }
                            else if(merek.status == "proses_cetak"){
                                merek.status = "Menunggu Proses Cetak"
                            }
                            else if(merek.status == "menunggu_tanggapan"){
                                merek.status = "Menunggu Tanggapan"
                            }
                            else if(merek.status == "sudah_keluar_sertifikat"){
                                merek.status = "Sudah Keluar Sertifikat"
                            }
                        });
                        this.dataMerekCount = response.data.count_merek[0].count;
                        this.filterMerek.noStart = this.filterMerek.offset + 1;
                        this.filterMerek.noEnd = this.filterMerek.offset + this.dataMerek.length;
                    }
                    else{
                        this.filterMerek.offset = 0;
                        this.filterMerek.noStart = 0;
                        this.filterMerek.noEnd = 0;
                        this.dataMerekCount = 0;
                        this.dataMerek = [];
                    }

                    //PELATIHAN
                    if(response.data.pelatihan.length > 0){
                        this.dataPelatihan = response.data.pelatihan;
                        this.dataPelatihan.forEach((pelatihan, index) => {
                            if(pelatihan.tanggal_mulai != undefined){
                                pelatihan.tanggal_mulai = new Date(pelatihan.tanggal_mulai).toString("dd MMMM yyyy");
                            }
                            if(pelatihan.tanggal_selesai != undefined){
                                pelatihan.tanggal_selesai = new Date(pelatihan.tanggal_selesai).toString("dd MMMM yyyy");
                            }

                        });
                        this.dataPelatihanCount = response.data.count_pelatihan[0].count;
                        this.filterPelatihan.noStart = this.filterPelatihan.offset + 1;
                        this.filterPelatihan.noEnd = this.filterPelatihan.offset + this.dataPelatihan.length;
                    }
                    else{
                        this.filterPelatihan.offset = 0;
                        this.filterPelatihan.noStart = 0;
                        this.filterPelatihan.noEnd = 0;
                        this.dataPelatihanCount = 0;
                        this.dataPelatihan = [];
                    }

                    //PAMERAN
                    if(response.data.pameran.length > 0){
                        this.dataPameran = response.data.pameran;
                        this.dataPameran.forEach((pameran, index) => {
                            if(pameran.tanggal_mulai != undefined){
                                pameran.tanggal_mulai = new Date(pameran.tanggal_mulai).toString("dd MMMM yyyy");
                            }
                            if(pameran.tanggal_selesai != undefined){
                                pameran.tanggal_selesai = new Date(pameran.tanggal_selesai).toString("dd MMMM yyyy");
                            }

                        });
                        this.dataPameranCount = response.data.count_pameran[0].count;
                        this.filterPameran.noStart = this.filterPameran.offset + 1;
                        this.filterPameran.noEnd = this.filterPameran.offset + this.dataPameran.length;
                    }
                    else{
                        this.filterPameran.offset = 0;
                        this.filterPameran.noStart = 0;
                        this.filterPameran.noEnd = 0;
                        this.dataPameranCount = 0;
                        this.dataPameran = [];
                    }

                    //PAMERAN
                    if(response.data.pemasaran.length > 0){
                        this.dataPemasaran = response.data.pemasaran;
                        this.dataPemasaran.forEach((pemasaran, index) => {
                            if(pemasaran.tanggal_mulai != undefined){
                                pemasaran.tanggal_mulai = new Date(pemasaran.tanggal_mulai).toString("dd MMMM yyyy");
                            }
                            if(pemasaran.tanggal_selesai != undefined){
                                pemasaran.tanggal_selesai = new Date(pemasaran.tanggal_selesai).toString("dd MMMM yyyy");
                            }

                        });
                        this.dataPemasaranCount = response.data.count_pemasaran[0].count;
                        this.filterPemasaran.noStart = this.filterPemasaran.offset + 1;
                        this.filterPemasaran.noEnd = this.filterPemasaran.offset + this.dataPemasaran.length;
                    }
                    else{
                        this.filterPemasaran.offset = 0;
                        this.filterPemasaran.noStart = 0;
                        this.filterPemasaran.noEnd = 0;
                        this.dataPemasaranCount = 0;
                        this.dataPemasaran = [];
                    }

                    if(type == "new"){
                        await this.setPaginataion();
                        this.setPaginataion();
                    }
                }
            }
        },

        setPaginataion(){
            $("#paginationIntervensi").pagination({
                items: app.dataIntervensiCount,
                itemsOnPage: 10,
                cssStyle: 'light-theme',
                prevText: "Sebelumnya",
                nextText: "Selanjutnya",
                onPageClick: function(pageNumber) {
                    app.intervenProp.offset = (pageNumber - 1) * 10;
                    app.submitFilter("changePage");
                }
            });

            $("#paginationHalal").pagination({
                items: app.dataHalalCount,
                itemsOnPage: 10,
                cssStyle: 'light-theme',
                prevText: "Sebelumnya",
                nextText: "Selanjutnya",
                onPageClick: function(pageNumber) {
                    app.filterHalal.offset = (pageNumber - 1) * 10;
                    app.submitFilter("changePage");
                }
            });

            $("#paginationMerek").pagination({
                items: app.dataMerekCount,
                itemsOnPage: 10,
                cssStyle: 'light-theme',
                prevText: "Sebelumnya",
                nextText: "Selanjutnya",
                onPageClick: function(pageNumber) {
                    app.filterMerek.offset = (pageNumber - 1) * 10;
                    app.submitFilter("changePage");
                }
            });

            $("#paginationPelatihan").pagination({
                items: app.dataPelatihanCount,
                itemsOnPage: 10,
                cssStyle: 'light-theme',
                prevText: "Sebelumnya",
                nextText: "Selanjutnya",
                onPageClick: function(pageNumber) {
                    app.filterPelatihan.offset = (pageNumber - 1) * 10;
                    app.submitFilter("changePage");
                }
            });

            $("#paginationPemasaran").pagination({
                items: app.dataPemasaranCount,
                itemsOnPage: 10,
                cssStyle: 'light-theme',
                prevText: "Sebelumnya",
                nextText: "Selanjutnya",
                onPageClick: function(pageNumber) {
                    app.filterPemasaran.offset = (pageNumber - 1) * 10;
                    app.submitFilter("changePage");
                }
            });

            $("#paginationPameran").pagination({
                items: app.dataPameranCount,
                itemsOnPage: 10,
                cssStyle: 'light-theme',
                prevText: "Sebelumnya",
                nextText: "Selanjutnya",
                onPageClick: function(pageNumber) {
                    app.filterPameran.offset = (pageNumber - 1) * 10;
                    app.submitFilter("changePage");
                }
            });
        },

        async exportExcel(){
            Swal.fire({
                title: 'Mohon Tunggu !',
                html: '',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            var data = {
                tanggal_mulai: this.tanggal_mulai,
                tanggal_selesai: this.tanggal_selesai,
                kata_kunci: this.kata_kunci,
                pelatihan:{
                    checked: this.jenis_intervensi[1].checked
                },
                pameran:{
                    checked: this.jenis_intervensi[2].checked
                },
                pemasaran:{
                    checked: this.jenis_intervensi[3].checked
                },
                halal: {
                    checked: this.jenis_intervensi[4].checked
                },
                merek: {
                    checked: this.jenis_intervensi[5].checked
                }
            }

            const response = await axios.post(this.url.exportExcel, data);

            var linkSource = response.data;
            var downloadLink = document.createElement("a");
            var fileName = 'Intervensi exported ' + new Date().toString('dd MMMM yyyy HH:mm') + '.xlsx';

            downloadLink.href = linkSource;
            downloadLink.download = fileName;
            downloadLink.click();

            Swal.close();
        }
    },
});

  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, (start, end, label) => {
    app.tanggal_mulai = start.format('YYYY-MM-DD');
    app.tanggal_selesai = end.format('YYYY-MM-DD');

    app.$forceUpdate();
  });

</script>

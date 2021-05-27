<script>
var app = new Vue({
    el: '#app',
    data: {
        url:{
            filter: "/monitoring/filter",
            exportExcel: "/monitoring/exportExcel",
            pelatihanDT: "/intervensi/pelatihan/getListDT",
            pameranDT: "/intervensi/pameran/getListDT",
            pemasaranDT: "/intervensi/pemasaran/getListDT",
            halalDT: "/intervensi/SertifikasiHalal/getListDT",
            merekDT: "/intervensi/SertifikasiMerek/getListDT",
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
        tanggal_mulai: "01/01/2017",
        tanggal_selesai: new Date().toString("MM/dd/yyyy"),
        intervensiTabs: [
            {
                nama: "Pelatihan",
                id: "tab-pelatihan",
                icon: "flaticon2-line-chart",
                active: true
            },
            {
                nama: "Bazar/Pameran",
                id: "tab-pameran",
                icon: "flaticon-business",
                active: true
            },
            {
                nama: "Pemasaran",
                id: "tab-pemasaran",
                icon: "flaticon2-shopping-cart",
                active: true
            },
            {
                nama: "Sertifikasi Halal",
                id: "tab-halal",
                icon: "flaticon-file-2",
                active: true
            },
            {
                nama: "Sertifikasi Merek",
                id: "tab-merek",
                icon: "flaticon-clipboard",
                active: true
            },
        ],
        dataTable:{}

    },

    async mounted(){
        this.initDateRange();
        this.getPelatihanDT();
        this.getPameranDT();
        this.getPemasaranDT();
        this.getHalalDT();
        this.getMerekDT();
        this.setActiveTab();
    },

    methods: {
        initDateRange(){
            $("#date-range").val(this.tanggal_mulai + " - " + this.tanggal_selesai);
        },

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

        submitFilter(){
            if(!this.validateIntervensi()){
                alert("Jenis intervensi tidak boleh kosong");
                return false;
            }

            //PELATIHAN
            if(this.jenis_intervensi[1].checked == true){
                this.getPelatihanDT();
                this.intervensiTabs[0].active = true;
            }
            else{
                this.intervensiTabs[0].active = false;
            }

            //MEREK
            if(this.jenis_intervensi[2].checked == true){
                this.getMerekDT();
                this.intervensiTabs[4].active = true;
            }
            else{
                this.intervensiTabs[4].active = false;
            }

            //PEMASARAN
            if(this.jenis_intervensi[3].checked == true){
                this.getPemasaranDT();
                this.intervensiTabs[2].active = true;
            }
            else{
                this.intervensiTabs[2].active = false;
            }

            //HALAL
            if(this.jenis_intervensi[4].checked == true){
                this.getHalalDT();
                this.intervensiTabs[3].active = true;
            }
            else{
                this.intervensiTabs[3].active = false;
            }

            //PAMERAN
            if(this.jenis_intervensi[5].checked == true){
                this.getPameranDT();
                this.intervensiTabs[1].active = true;
            }
            else{
                this.intervensiTabs[1].active = false;
            }

            setTimeout( () => {
                this.setActiveTab();
            }, 10);

        },

        validateIntervensi(){
            for (let i = 0; i < this.jenis_intervensi.length; i++) {
                if(this.jenis_intervensi[i].checked == true) return true;
            }

            return false;
        },

        setActiveTab(){
            for (let i = 0; i < this.intervensiTabs.length; i++) {
                if(this.intervensiTabs[i].active == true){
                    $("#link-"+this.intervensiTabs[i].id).click();
                    return false;
                }
            }
        },

        getPelatihanDT(){
            this.dataTable.pelatihan = $('#table-pelatihan').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: this.url.pelatihanDT,
                    data: (d) => {
                        return $.extend( {}, d, {
                            tanggalMulai: new Date(this.tanggal_mulai).toString("yyyy-MM-dd"),
                            tanggalSelesai: new Date(this.tanggal_selesai).toString("yyyy-MM-dd")
                        });
                    }
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'nama_intervensi'},
                    {data: 'lokasi'},
                    {
                        data: 'tanggal_mulai',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            return new Date(row.tanggal_mulai).toString("dd MMMM yyyy")
                        }
                    },
                    {
                        data: 'tanggal_selesai',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            return new Date(row.tanggal_selesai).toString("dd MMMM yyyy")
                        }
                    },
                    {data: 'deskripsi'}
                ]
            });
        },

        getPameranDT(){
            this.dataTable.pameran = $('#table-pameran').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: this.url.pameranDT,
                    data: (d) => {
                        return $.extend( {}, d, {
                            tanggalMulai: new Date(this.tanggal_mulai).toString("yyyy-MM-dd"),
                            tanggalSelesai: new Date(this.tanggal_selesai).toString("yyyy-MM-dd")
                        });
                    }
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        sortable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'nama_intervensi'},
                    {data: 'lokasi'},
                    {
                        data: 'tanggal_mulai',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            return new Date(row.tanggal_mulai).toString("dd MMMM yyyy")
                        }
                    },
                    {
                        data: 'tanggal_selesai',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            return new Date(row.tanggal_selesai).toString("dd MMMM yyyy")
                        }
                    },
                    {data: 'deskripsi'}
                ]
            });
        },

        getPemasaranDT(){
            this.dataTable.pemasaran = $('#table-pemasaran').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: this.url.pemasaranDT,
                    data: (d) => {
                        return $.extend( {}, d, {
                            tanggalMulai: new Date(this.tanggal_mulai).toString("yyyy-MM-dd"),
                            tanggalSelesai: new Date(this.tanggal_selesai).toString("yyyy-MM-dd")
                        });
                    }
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        sortable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'nama_intervensi'},
                    {data: 'lokasi'},
                    {
                        data: 'tanggal_mulai',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            return new Date(row.tanggal_mulai).toString("dd MMMM yyyy")
                        }
                    },
                    {
                        data: 'tanggal_selesai',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            return new Date(row.tanggal_selesai).toString("dd MMMM yyyy")
                        }
                    },
                    {data: 'deskripsi'}
                ]
            });
        },

        getHalalDT(){
            this.dataTable.halal = $('#table-halal').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: this.url.halalDT,
                    data: (d) => {
                        return $.extend( {}, d, {
                            tanggalMulai: new Date(this.tanggal_mulai).toString("yyyy-MM-dd"),
                            tanggalSelesai: new Date(this.tanggal_selesai).toString("yyyy-MM-dd")
                        });
                    }
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        sortable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'nama_usaha'},
                    {
                        data: 'tgl_permohonan',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            return new Date(row.tgl_permohonan).toString("dd MMMM yyyy")
                        }
                    },
                    {
                        data: 'status',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            if(row.status == "sudah_keluar_sertifikat") return "Sudah Keluar Sertifikat";
                            else if(row.status == "didaftar") return "Didaftar";
                            else if(row.status == "ditolak") return "Ditolak";
                        }
                    },
                    {data: 'no_sertifikat'},
                    {
                        data: 'tgl_sertifikat',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            if(row.tgl_sertifikat == null) return row.tgl_sertifikat;
                            return new Date(row.tgl_sertifikat).toString("dd MMMM yyyy");
                        }
                    },
                    {data: 'keterangan'}
                ]
            });
        },

        getMerekDT(){
            this.dataTable.merek = $('#table-merek').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: this.url.merekDT,
                    data: (d) => {
                        return $.extend( {}, d, {
                            tanggalMulai: new Date(this.tanggal_mulai).toString("yyyy-MM-dd"),
                            tanggalSelesai: new Date(this.tanggal_selesai).toString("yyyy-MM-dd")
                        });
                    }
                },
                columns: [
                    {
                        data: null,
                        sortable: false,
                        sortable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'nama_usaha'},
                    {data: 'nama_merek'},
                    {data: 'no_permohonan'},
                    {
                        data: 'tgl_berkas_kemenkumham',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            if(row.tgl_berkas_kemenkumham == null) return row.tgl_berkas_kemenkumham;
                            return new Date(row.tgl_berkas_kemenkumham).toString("dd MMMM yyyy");
                        }
                    },
                    {
                        data: 'status',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            if(row.status == "sudah_keluar_sertifikat") return "Sudah Keluar Sertifikat";
                            else if(row.status == "proses_cetak") return "Proses Cetak";
                            else if(row.status == "menunggu_tanggapan") return "Menuggu Tanggapan";
                            else if(row.status == "ditolak") return "Ditolak";
                        }
                    },
                    {data: 'no_sertifikat'},
                    {
                        data: 'tgl_sertifikat',
                        class: ['text-nowrap'],
                        render: function (data, type, row, meta) {
                            if(row.tgl_sertifikat == null) return row.tgl_sertifikat;
                            return new Date(row.tgl_sertifikat).toString("dd MMMM yyyy");
                        }
                    },
                ]
            });
        },

        async exportExcel(){
            if(!this.validateIntervensi()){
                alert("Jenis intervensi tidak boleh kosong");
                return false;
            }

            Swal.fire({
                title: 'Mohon Tunggu !',
                html: '',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            });

            let tanggal_mulai = new Date(this.tanggal_mulai).toString('dd-MM-yyyy');
            let tanggal_selesai = new Date(this.tanggal_selesai).toString('dd-MM-yyyy');

            var data = {
                tanggal_mulai: tanggal_mulai,
                tanggal_selesai: tanggal_selesai,
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

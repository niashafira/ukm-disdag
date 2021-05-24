<script>
var app = new Vue({
        el: '#app',
        data: {
            api:{
                dataUkm: "/api/ukm",
                checkDuplicate: "/ukm/checkDuplicate"
            },
            ukm: {
                nama_pemilik: "",
                nik: "",
                nama_usaha: "",
                jenis_produksi: "",
                alamat: "",
                jangkauan_pemasaran: "",
                no_telp: "",
                email: "",
                no_siup: "",
                no_nib: "",
                no_tdp: "",
                no_iumk: "",
                no_pirt: "",
                no_bpom: "",
                jumlah_pemodalan: "",
                sumber_pemodalan: "",
                jumlah_pinjaman: "",
                sumber_pinjaman: "",
                no_sertifikasi_halal: "",
                no_sertifikasi_merek: "",
            },
            omset: [],
            statusDuplicate: null,
            duplicate: {}

        },

        mounted(){
            this.tambahOmset();
        },

        methods: {
            tambahOmset(){
                this.omset.push({
                    tanggal: "",
                    jumlah: ""
                });

                setTimeout(() =>
                {
                    var id = this.omset.length - 1;
                    $("#datepicker" + id).datepicker({
                        format: "mm-yyyy",
                        startView: "months",
                        minViewMode: "months"
                    });
                    $("#datepicker" + id).change(function() {
                        $(this)[0].dispatchEvent(new Event('input'));
                    });
                }, 100);
            },

            async checkDuplicate(){
                this.statusDuplicate = null;
                if(this.ukm.nik != ""){
                    const response = await axios.post(this.api.checkDuplicate, {nik: this.ukm.nik});
                    ((response.data.status == 'E') ? this.statusDuplicate = true : this.statusDuplicate = false)
                    if(response.data.status == 'E'){
                        this.statusDuplicate = true;
                        this.duplicate.nik = this.ukm.nik;
                        this.duplicate.data = response.data.data;

                    }
                }

            },

            openModalDuplicate(){
                $("#modal-duplicate").modal("show");
            },

            simpan(){

                var data = {
                    ukm: this.ukm,
                    omset: this.omset
                }

                Swal.fire({
                    title: 'Apakah anda yakin ?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Mohon Tunggu !',
                            html: '',
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        });

                        var url = "/ukm/store";

                        axios.post(url, data).then(response => {
                            if(response.data == "sukses"){
                                Swal.close();
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data Berhasil Disimpan',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                window.location = "/ukm";
                            }
                        });
                    }
                });

            }

        },
});

</script>

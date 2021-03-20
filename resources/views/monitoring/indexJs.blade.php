<script>
var app = new Vue({
    el: '#app',
    data: {
        url:{
            filter: "/monitoring/filter"
        },

        jenis_intervensi:[
            {
                jenis: "Semua",
                checked: true
            },
            {
                jenis: "Pelatihan",
                checked: true
            },
            {
                jenis: "Pameran / Bazar",
                checked: true
            },
            {
                jenis: "Pemasaran",
                checked: true
            },
            {
                jenis: "Halal",
                checked: true
            },
            {
                jenis: "Merek",
                checked: true
            },
            {
                jenis: "Lainnya",
                checked: true
            }
        ],
        tanggal_mulai: "",
        tanggal_selesai: "",
        kata_kunci: ""
    },

    mounted(){

    },

    methods: {
        onChangeIntervensi(jenis){
            console.log(jenis);
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
            var data = {
                jenis_intervensi: this.jenis_intervensi,
                tanggal_mulai: this.tanggal_mulai,
                tanggal_selesai: this.tanggal_selesai,
                kata_kunci: this.kata_kunci
            };

            axios.post(this.url.filter, data).then(response => {
                if(response.data == "sukses"){
                    Swal.close();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data Berhasil Disimpan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    window.location = "/intervensi/lainnya";
                }
            });
        }
    },
});

  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, (start, end, label) => {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    app.tanggal_mulai = start.format('YYYY-MM-DD');
    app.tanggal_selesai = end.format('YYYY-MM-DD');

    app.$forceUpdate();
  });

</script>

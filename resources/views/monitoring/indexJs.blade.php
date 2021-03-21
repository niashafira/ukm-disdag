<script>
var app = new Vue({
    el: '#app',
    data: {
        url:{
            filter: "/monitoring/filter"
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
                key: "pameran",
                jenis: "Pameran / Bazar",
                checked: true
            },
            {
                key: "pemasaran",
                jenis: "Pemasaran",
                checked: true
            },
            {
                key: "halal",
                jenis: "Halal",
                checked: true
            },
            {
                key: "merek",
                jenis: "Merek",
                checked: true
            },
            {
                key: "lainnya",
                jenis: "Lainnya",
                checked: true
            }
        ],
        tanggal_mulai: "",
        tanggal_selesai: "",
        kata_kunci: "",
        dataIntervensi: []
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
            var checked_jenis = [];
            for (let i = 1; i < this.jenis_intervensi.length; i++) {
                if(this.jenis_intervensi[i].checked == true){
                    checked_jenis.push(this.jenis_intervensi[i]);
                }

            }
            var data = {
                jenis_intervensi: checked_jenis,
                tanggal_mulai: this.tanggal_mulai,
                tanggal_selesai: this.tanggal_selesai,
                kata_kunci: this.kata_kunci
            };

            axios.post(this.url.filter, data).then(response => {
                if(response.data.status == "S"){
                    this.dataIntervensi = response.data.data;
                    this.dataIntervensi.forEach((intervensi) => {
                        intervensi.tanggal_mulai = new Date(intervensi.tanggal_mulai).toString("dd MMMM yyyy");
                        intervensi.tanggal_selesai = new Date(intervensi.tanggal_selesai).toString("dd MMMM yyyy");
                    });
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

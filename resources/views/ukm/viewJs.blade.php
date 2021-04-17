<script>
    var app = new Vue({
        el: '#app',
        data: {
            ukm: {
                profil: {}
            }
        },

        mounted(){
            this.initData();
        },

        methods:{
            initData(){
                var data = <?= json_encode($data); ?>;
                this.ukm = data;
                this.ukm.intervensi.forEach((intervensi) => {
                    if(intervensi.tanggal_mulai != undefined){
                        intervensi.tanggal_mulai = new Date(intervensi.tanggal_mulai).toString("dd MMMM yyyy");
                    }

                    if(intervensi.jenis_intervensi == "pelatihan"){
                        intervensi.linkDetail = "/intervensi/pelatihan/view/"+intervensi.id;
                    }
                    if(intervensi.jenis_intervensi == "pameran"){
                        intervensi.linkDetail = "/intervensi/pameran/view/"+intervensi.id;
                    }
                    if(intervensi.jenis_intervensi == "pemasaran"){
                        intervensi.linkDetail = "/intervensi/pemasaran/view/"+intervensi.id;
                    }
                    if(intervensi.jenis_intervensi == "lainnya"){
                        intervensi.linkDetail = "/intervensi/lainnya/view/"+intervensi.id;
                    }
                });

                setTimeout(() => {
                    $('#table-intervensi').DataTable();
                }, 10);
            },
        }
    });

</script>

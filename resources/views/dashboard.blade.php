@extends('template-metronics.index')

@section('title')
Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <h1>Dashboard</h1>
        <div class="row" style="margin-top:3%">
            <div class="col-md-4">
                <div class="card card-custom bg-info card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body">
                        <span class="svg-icon svg-icon-2x svg-icon-white">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                    <path
                                        d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                    <path
                                        d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                        fill="#000000" fill-rule="nonzero"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span
                            class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">@{{ count_ukm }}</span>
                        <span class="font-weight-bold text-white font-size-sm">UKM Terdaftar</span>
                    </div>
                    <!--end::Body-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom bg-danger card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body">
                        <span class="svg-icon svg-icon-2x svg-icon-white">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5">
                                    </rect>
                                    <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5"></rect>
                                    <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5"></rect>
                                    <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5"></rect>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span
                            class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block">@{{ count_intervensi_year }}</span>
                        <span class="font-weight-bold text-white font-size-sm">Intervensi Tahun @{{ year_now }}</span>
                    </div>
                    <!--end::Body-->
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-custom bg-dark card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body">
                        <span class="svg-icon svg-icon-2x svg-icon-white">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <path
                                        d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z"
                                        fill="#000000"></path>
                                    <path
                                        d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"
                                        fill="#000000" opacity="0.3"></path>
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span
                            class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 text-hover-primary d-block">@{{ count_intervensi }}</span>
                        <span class="font-weight-bold text-white font-size-sm">Total Intervensi</span>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Grafik Jenis Intervensi</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Chart-->
                        <div id="chart" class="d-flex justify-content-center"></div>
                        <!--end::Chart-->
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Grafik Pertumbuhan Intervensi</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Chart-->
                        <div id="chart2" class="d-flex justify-content-center"></div>
                        <!--end::Chart-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
{{-- <script src="{{asset('template-metronics/assets/js/pages/features/charts/apexcharts.js')}}"></script> --}}

<script>
    var app = new Vue({
        el: '#app',
        data: {
            count_ukm: "",
            count_intervensi: "",
            count_intervensi_year: "",
            year_now: "",
            count_jenis_intervensi: [],
            jenis_intervensi: ['Pelatihan', 'Pameran', 'Pemasaran', 'Sertifikasi Halal', 'Sertifikasi Merek',
                'Lainnya'
            ],
            pertumbuhan_intervensi: []
        },

        mounted() {
            this.initData();
            this.initPieChart();
            this.initMultiAxis();
        },

        methods: {
            initData() {
                this.count_ukm = <?= json_encode($count_ukm) ?>;
                this.count_intervensi = <?= json_encode($count_intervensi) ?>;
                this.count_intervensi_year = <?= json_encode($count_intervensi_year) ?>;
                this.year_now = <?= json_encode($year) ?>;

                this.count_jenis_intervensi = <?= json_encode($count_jenis_intervensi) ?>;

                this.pertumbuhan_intervensi = <?= json_encode($pertumbuhan_intervensi) ?>;
            },

            initPieChart() {
                var options = {
                    series: this.count_jenis_intervensi,
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: this.jenis_intervensi,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        },
                    }],
                    colors: ['#00e396', '#feb019', '#008ffb', '#ff4560', '#775dd0', '#a917bb']
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            },

            initMultiAxis() {
                var options = {
                    series: [{
                        name: "Intervensi",
                        data: this.pertumbuhan_intervensi.data
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        zoom: {
                            enabled: false
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
                            colors: ['#f3f3f3',
                            'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: this.pertumbuhan_intervensi.years,
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart2"), options);
                chart.render();

            }
        }
    });

</script>

@endsection

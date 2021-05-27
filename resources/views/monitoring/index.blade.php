@extends('template-metronics.index')

@section('title')
Monitoring Intervensi
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .checkbox-menu li label {
            display: block;
            padding: 3px 10px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333;
            white-space: nowrap;
            margin:0;
            transition: background-color .4s ease;
        }
        .checkbox-menu li input {
            margin: 0px 5px;
            top: 2px;
            position: relative;
        }

        .checkbox-menu li.active label {
            background-color: #cbcbff;
            font-weight:bold;
        }

        .checkbox-menu li label:hover,
        .checkbox-menu li label:focus {
            background-color: #f5f5f5;
        }

        .checkbox-menu li.active label:hover,
        .checkbox-menu li.active label:focus {
            background-color: #b8b8ff;
        }

        .dataTables_wrapper .dataTable th.sorting_asc, .dataTables_wrapper .dataTable td.sorting_asc{
            color: white !important;
        }

        .dataTables_wrapper .dataTable th.sorting_desc, .dataTables_wrapper .dataTable td.sorting_desc{
            color: white !important;
        }

    </style>
@endsection

@section('content')

<h3>Monitoring Intervensi</h3>
<hr>

<div class="row">
    <div class="col-md-12 card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5>Jenis Intervensi</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6" v-for="(jenis, index) in jenis_intervensi" :key="index">
                            <div class="form-check">
                                <input v-on:change="onChangeIntervensi(jenis)" v-model="jenis.checked" class="form-check-input" type="checkbox" value="" :id="jenis.jenis">
                                <label class="form-check-label" :for="jenis.jenis">
                                    @{{ jenis.jenis }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <h5>Tanggal Intervensi</h5>
                    <hr>
                    <div class="form-group">
                        <input id="date-range" class="form-control" type="text" name="daterange" value="" />
                    </div>
                </div>

            </div>

            <div class="row d-flex justify-content-end" style="margin-top:3%">
                <div class="col-md-3">
                    {{-- <div class="btn-group" role="group" aria-label="Basic example">

                    </div> --}}
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <button id="btn-filter" class="btn btn-sm btn-success mr-2" v-on:click="exportExcel()"><span class="fa fa-file-excel"></span> Export Excel</button>
                        <button id="btn-filter" class="btn btn-sm btn-info mr-2" v-on:click="submitFilter('new')"><span class="fa fa-filter"></span> Filter</button>
                    </div>
                    {{-- <button id="btn-filter" class="btn btn-sm btn-success" v-on:click="exportExcel()"><span class="fa fa-file-excel"></span> Export Excel</button> --}}
                </div>
                {{-- <div class="col-md-3">
                    <button id="btn-filter" class="btn btn-sm btn-info" v-on:click="submitFilter('new')"><span class="fa fa-filter"></span> Filter</button>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 3%">
    <div class="col-md-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" v-for="(tab, index) in intervensiTabs" :key="index" v-if="tab.active == true">
                <a :id="'link-' + tab.id" class="nav-link" data-toggle="tab" :href="'#'+tab.id">
                    <span class="nav-icon">
                        <i :class="tab.icon"></i>
                    </span>
                    <span class="nav-text">@{{ tab.nama }}</span>
                </a>
            </li>
        </ul>

        <div class="tab-content mt-5" id="myTabContent">
            <div class="tab-pane fade active show" id="tab-pelatihan" role="tabpanel" aria-labelledby="tab-pelatihan">
                <div class="col-md-12 table-responsive">
                    <table id="table-pelatihan" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-white bg-primary">No</th>
                                <th class="text-white bg-primary">Nama Pelatihan</th>
                                <th class="text-white bg-primary">Lokasi</th>
                                <th class="text-white bg-primary">Tanggal Mulai</th>
                                <th class="text-white bg-primary">Tanggal Selesai</th>
                                <th class="text-white bg-primary">Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-pameran" role="tabpanel" aria-labelledby="tab-pameran">
                <div class="col-md-12 table-responsive">
                    <table id="table-pameran" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-white bg-primary">No</th>
                                <th class="text-white bg-primary">Nama</th>
                                <th class="text-white bg-primary">Lokasi</th>
                                <th class="text-white bg-primary">Tanggal Mulai</th>
                                <th class="text-white bg-primary">Tanggal Selesai</th>
                                <th class="text-white bg-primary">Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-pemasaran" role="tabpanel" aria-labelledby="tab-pemasaran">
                <div class="col-md-12 table-responsive">
                    <table id="table-pemasaran" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-white bg-primary">No</th>
                                <th class="text-white bg-primary">Nama</th>
                                <th class="text-white bg-primary">Lokasi</th>
                                <th class="text-white bg-primary">Tanggal Mulai</th>
                                <th class="text-white bg-primary">Tanggal Selesai</th>
                                <th class="text-white bg-primary">Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-halal" role="tabpanel" aria-labelledby="tab-halal">
                <div class="col-md-12 table-responsive">
                    <table id="table-halal" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-white bg-primary">No</th>
                                <th class="text-white bg-primary">Nama UKM</th>
                                <th class="text-white bg-primary">Tanggal Permohonan</th>
                                <th class="text-white bg-primary">Status</th>
                                <th class="text-white bg-primary">No Sertifikat</th>
                                <th class="text-white bg-primary">Tanggal Sertifikat</th>
                                <th class="text-white bg-primary">Keterangan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-merek" role="tabpanel" aria-labelledby="tab-merek">
                <div class="col-md-12 table-responsive">
                    <table id="table-merek" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-white bg-primary">No</th>
                                <th class="text-white bg-primary">Nama UKM</th>
                                <th class="text-white bg-primary">Nama Merek</th>
                                <th class="text-white bg-primary">No Permohonan</th>
                                <th class="text-white bg-primary">Tanggal Permohonan</th>
                                <th class="text-white bg-primary">Status</th>
                                <th class="text-white bg-primary">No Sertifikat</th>
                                <th class="text-white bg-primary">Tanggal Sertifikat</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>




@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    @include('monitoring.indexJs')
@endsection

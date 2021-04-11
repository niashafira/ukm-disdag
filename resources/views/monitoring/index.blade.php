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
    </style>
@endsection

@section('content')

<h3>Monitoring Intervensi</h3>
<hr>

<div class="row">
    <div class="col-md-12 card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
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

                <div class="col-md-4">
                    <h5>Tanggal Intervensi</h5>
                    <hr>
                    <div class="form-group">
                        <input class="form-control" type="text" name="daterange" value="01/01/2019 - 01/15/2021" />
                    </div>
                </div>

                <div class="col-md-4">
                    <h5>Spesifik Kata Kunci</h5>
                    <hr>
                    <div class="form-group">
                        <input v-model="kata_kunci" class="form-control" type="text" placeholder="Spesifik kata kunci" />
                    </div>
                </div>

            </div>

            <div class="row d-flex justify-content-center" style="margin-top:3%">
                <div class="col-md-6">
                    <button class="btn btn-sm btn-success btn-block" v-on:click="submitFilter('new')"><span class="fa fa-filter"></span> Filter</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 3%">
    <div class="col-md-12">
        <div class="dropdown">
            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fa fa-print"></span> Export
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Cetak</a>
                <a class="dropdown-item" href="#">Excel</a>
                <a class="dropdown-item" href="#">PDF</a>
            </div>
        </div>

        <div v-if="dataIntervensiCount > 0">
            <div class="table-responsive">
                <table class="table table-bordered" style="margin-top:3%">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Lokasi</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-nowrap text-center">Tanggal Mulai</th>
                            <th class="text-nowrap text-center">Tanggal Selesai</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(intervensi, index) in dataIntervensi" :key="index">
                            <td>@{{ intervenProp.offset + 1 + index }}</td>
                            <td>@{{ intervensi.jenis_intervensi }}</td>
                            <td>@{{ intervensi.nama_intervensi }}</td>
                            <td>@{{ intervensi.lokasi }}</td>
                            <td>@{{ intervensi.deskripsi }}</td>
                            <td class="text-nowrap">@{{ intervensi.tanggal_mulai }}</td>
                            <td class="text-nowrap">@{{ intervensi.tanggal_selesai }}</td>
                            <td><button class="btn btn-sm btn-success"><span class="fa fa-eye"></span> Detail</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <span>Menampilkan @{{ intervenProp.noStart }} - @{{ intervenProp.noEnd }} dari @{{ dataIntervensiCount }} data</span>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    <div id="paginationIntervensi"></div>
                </div>
            </div>
        </div>

        {{-- MEREK --}}
        <div v-if="dataMerekCount > 0">
            <h3 style="margin-top: 5%">Data Sertifikasi Merek</h3>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Nama UKM</th>
                        <th>Tanggal Permohonan</th>
                        <th>Status</th>
                        <th>No Sertifikat</th>
                        <th>Tanggal Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(merek, index) in dataMerek" :key="index">
                        <td>@{{ merek.nama_usaha }}</td>
                        <td>@{{ merek.tgl_berkas_kemenkumham }}</td>
                        <td>
                            <span v-if="merek.status == 'Menunggu Proses Cetak' || merek.status == 'Menunggu Tanggapan'" class="badge badge-warning">@{{ merek.status }}</span>
                            <span v-if="merek.status == 'Sudah Keluar Sertifikat'" class="badge badge-success">@{{ merek.status }}</span>
                            <span v-if="merek.status == 'Ditolak'" class="badge badge-danger">@{{ merek.status }}</span>
                        </td>
                        <td>@{{ merek.no_sertifikat }}</td>
                        <td>@{{ merek.tgl_sertifikat }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-4">
                    <span>Menampilkan @{{ filterMerek.noStart }} - @{{ filterMerek.noEnd }} dari @{{ dataMerekCount }} data</span>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    <div id="paginationMerek"></div>
                </div>
            </div>
        </div>


        {{-- HALAL --}}
        <div v-if="dataHalalCount > 0">
            <h3 style="margin-top: 5%">Data Sertifikasi Halal</h3>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-primary text-white">
                        <th>Nama UKM</th>
                        <th>Tanggal Permohonan</th>
                        <th>Status</th>
                        <th>No Sertifikat</th>
                        <th>Tanggal Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(halal, index) in dataHalal" :key="index">
                        <td>@{{ halal.nama_usaha }}</td>
                        <td>@{{ halal.tgl_permohonan }}</td>
                        <td>
                            <span v-if="halal.status == 'Menunggu Proses Cetak' || halal.status == 'Menunggu Tanggapan'" class="badge badge-warning">@{{ halal.status }}</span>
                            <span v-if="halal.status == 'Sudah Keluar Sertifikat'" class="badge badge-success">@{{ halal.status }}</span>
                            <span v-if="halal.status == 'Ditolak'" class="badge badge-danger">@{{ halal.status }}</span>
                        </td>
                        <td>@{{ halal.no_sertifikat }}</td>
                        <td>@{{ halal.tgl_sertifikat }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-4">
                    <span>Menampilkan @{{ filterHalal.noStart }} - @{{ filterHalal.noEnd }} dari @{{ dataHalalCount }} data</span>
                </div>
                <div class="col-md-8 d-flex justify-content-end">
                    <div id="paginationHalal"></div>
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

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
    <div class="col-md-3 card">
        <div class="card-body">
            <h5>Jenis Intervensi</h5>
            <hr>
            <div class="form-check" v-for="(jenis, index) in jenis_intervensi" :key="index">
                <input v-on:change="onChangeIntervensi(jenis)" v-model="jenis.checked" class="form-check-input" type="checkbox" value="" :id="jenis.jenis">
                <label class="form-check-label" :for="jenis.jenis">
                    @{{ jenis.jenis }}
                </label>
            </div>
            <h5 style="margin-top:5%">Tanggal Intervensi</h5>
            <hr>
            <div class="form-group">
                <input class="form-control" type="text" name="daterange" value="01/01/2018 - 01/15/2018" />
            </div>

            <h5 style="margin-top:5%">Spesifik Kata Kunci</h5>
            <hr>
            <div class="form-group">
                <input v-model="kata_kunci" class="form-control" type="text" placeholder="Spesifik kata kunci" />
            </div>

            <button class="btn btn-sm btn-success btn-block" v-on:click="submitFilter()"><span class="fa fa-search"></span> Filter</button>
        </div>
    </div>
    <div class="col-md-9">
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

        <table class="table table-bordered" style="margin-top:3%">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Jenis Intervensi</th>
                    <th>Nama Intervensi</th>
                    <th>Lokasi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>


@endsection

@section('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    @include('monitoring.indexJs')
@endsection

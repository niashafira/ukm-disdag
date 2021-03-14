@extends('template-metronics.index')

@section('title')
Monitoring Intervensi
@endsection

@section('content')

<h3>Monitoring Intervensi</h3>
<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis Intervensi</th>
            <th>Nama Intervensi</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
</table>


@endsection

@section('script')
    @include('monitoring.indexJs')
@endsection

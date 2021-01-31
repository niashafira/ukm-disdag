@extends('template-metronics.index')

@section('title')
Data Referensi
@endsection

@section('content')


<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <a href="/referensi/create" style="margin-bottom: 2%" class="btn btn-primary btn-sm"><span class="fa fa-plus"></span> Tambah</a>
        <table id="table-referensi" class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Referensi Key</th>
                    <th>Keterangan</th>
                    <th class="text-center" style="width:25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                ?>
                @foreach ($referensi as $referensi)
                <tr>
                    <td>{{ $i . "." }} </td>
                    <td>{{ $referensi->ref_id }}</td>
                    <td>{{ $referensi->keterangan }}</td>
                    <td class="text-center" style="width: 22%">
                        <button class="btn btn-primary btn-edit btn-sm"><span
                                class="fa fa-eye"></span> View</button>
                        <button class="btn btn-warning btn-edit btn-sm" id="{{ $referensi->id }}"><span
                                class="fa fa-pen"></span> Edit</button>
                        <button class="btn btn-danger btn-delete btn-sm" id="{{ $referensi->id }}"><span
                                class="fa fa-trash"></span> Delete</button>
                    </td>
                </tr>
                <?php
                    $i++;
                ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
    <script>
        $("#table-referensi").DataTable();
    </script>
@endsection

@extends('layouts.index')

@section('title')
Data UKM
@endsection

@section('content')
  <?php
      if(!isset($mode))
      $mode = "create"
  ?>

  <div class="row">
    <div class="col">
      <div class="form-group">
        <label>Nama UKM</label>
        <input type="text" name="nama_ukm" class="form-control" placeholder="Nama UKM"
            value="{{ isset($data->nama_ukm) ? $data->nama_ukm : '' }}">
      </div>
    </div>

    <div class="col">
      <div class="form-group">
        <label>Nama Pemilik</label>
        <input type="text" name="nama_pemilik" class="form-control" placeholder="Nama Pemilik UKM"
            value="{{ isset($data->nama_pemilik) ? $data->nama_pemilik : '' }}">
      </div>
    </div>

    <div class="col">
      <div class="form-group">
        <label>NIK</label>
        <input type="text" name="nik" class="form-control" placeholder="NIK Pemilik UKM"
            value="{{ isset($data->nik) ? $data->nik : '' }}">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col">
      <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat" class="form-control" placeholder="Alamat Pemilik UKM"
            value="{{ isset($data->alamat) ? $data->alamat : '' }}">
      </div>
    </div>

    <div class="col">
      <div class="form-group">
        <label>No Telp</label>
        <input type="text" name="no_telp" class="form-control" placeholder="No Telp Pemilik UKM"
            value="{{ isset($data->no_telp) ? $data->no_telp : '' }}">
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col">
      <h4>Detail Intervensi</h4>
      <button id="btn-add-intervensi" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Tambah</button>
      
      
      {{-- <table class="table table-bordered table-hover" style="margin-top: 1%">
        <thead>
          <tr>
            <th>Jenis Intervensi</th>
            <th>Deskripsi</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Akhir</th>
            <th>Lokasi</th>
            <th>No. Permohonan</th>
            <th>No. Sertifikat</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr id="batas-intervensi"></tr>
        </tbody>
      </table> --}}
      <div id="batas-intervensi"></div>

    </div>
  </div>
  
  <div style="display: none">
    <div class="row" id="add-intervensi">
      <div class="col">
        <div class="form-group">
          <label>Jenis Intervensi</label>
          <input type="text" class="form-control">
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>Jenis Intervensi</label>
          <input type="text" class="form-control">
        </div>
      </div>

      <div class="col">
        <div class="form-group">
          <label>Jenis Intervensi</label>
          <input type="text" class="form-control">
        </div>
      </div>
    </div>

    <table>
      <tr id="row-intervensi">
        <td>
            <select class="form-control">
              <option selected disabled>--Pilih Jenis Intervensi--</option>
              @foreach ($jenis_intervensi as $intervensi)
                <option value="{{ $intervensi->id }}"> {{ $intervensi->jenis }} </option>
              @endforeach
            </select>
        </td>
        <td><input type="text" class="form-control" /></td>
        <td><input type="text" class="form-control" /></td>
        <td><input type="text" class="form-control" /></td>
        <td><input type="text" class="form-control" /></td>
        <td><input type="text" class="form-control" /></td>
        <td><input type="text" class="form-control" /></td>
        <td class="text-center"><button class="btn btn-danger btn-delete btn-sm"><span class="fa fa-trash"></span></button></td>
      </tr>
    </table>
  </div>
@endsection

@section('script')
  <script>
    $("#btn-add-intervensi").click(function(){
      $("#add-intervensi").clone()
      .insertBefore("#batas-intervensi")
      .find("input:text").val("").end();
    });
    $(document).ready(function() {
        $('.js-basic-single').select2();
    });
  </script>
@endsection



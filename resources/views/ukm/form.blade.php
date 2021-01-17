@extends('template.index')

@section('title')
Data UKM
@endsection

@section('content')
  <?php
      if(!isset($mode))
      $mode = "create"
  ?>

  <div class="row">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="row">
          <div class="col-md-12">
            <div class="card-body">
              <h4 class="card-title">Form Data UKM</h4>
              <div class="row">
                <div class="col-4">
                  <div class="form-group">
                    <label>Nama UKM</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Nama UKM">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label>Nama Pemilik</label>
                    <input type="text" class="form-control form-control-sm" placeholder="Nama Pemilik">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control form-control-sm" placeholder="NIK">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label>No Telp</label>
                    <input type="text" class="form-control form-control-sm" placeholder="No Telp">
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control form-control-sm"></textarea>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <button class="btn btn-sm btn-info" id="add-intervensi"><span class="fa fa-plus"></span> Tambah Intervensi</button>
  <div class="row" id="section-intervensi" style="margin-top: 1%">
    
  </div>

  <div style="display: none">
    <div id="tmpl-intervensi">
      
      <div class="col-4 grid-margin stretch-card" id="__INDEX__">
        <div class="card" style="min-height: 350px">
          <div class="row">
            <div class="col-md-12">
              <div class="card-body">
  
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Jenis Intervensi</label>
                  <select data-index="__INDEX__" class="form-control form-control-sm select-intervensi">
                    <option selected disabled>--Pilih Jenis Intervensi--</option>
                    @foreach ($jenis_intervensi as $intervensi)
                     <option value="{{$intervensi->id}}">{{$intervensi->jenis}}</option>   
                    @endforeach
                  </select>
                </div>
  
                <div class="section-intervensi-form"></div>
                
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection

@section('script')
  <script>
    var index_intervensi = 1;
    $("#add-intervensi").click(function(){
      var tmpl = $("#tmpl-intervensi").html().replace(/__INDEX__/g, "intervensi"+index_intervensi);
      $("#section-intervensi").append(tmpl);
      index_intervensi++;
    });

    $(document).on("change",".select-intervensi", function(){
      var id_element = $(this).data("index");
      var id_jenis = $(this).val();
      setForm(id_jenis, id_element);
    });

    function setForm(id_jenis, id_element){
      var template_form = {
        pelatihan: '<div class="form-group">'+
                  '<label>Deskripsi</label>'+
                  '<textarea class="form-control form-control-sm"></textarea>'+
                '</div>'+
                '<div class="row">'+
                  '<div class="col-6">'+
                    '<div class="form-group">'+
                      '<label>Tanggal Mulai</label>'+
                      '<input type="date" class="form-control form-control-sm">'+
                    '</div>'+
                  '</div>'+
                  '<div class="col-6">'+
                    '<div class="form-group">'+
                      '<label>Tanggal Selesai</label>'+
                      '<input type="date" class="form-control form-control-sm">'+
                    '</div>'+
                  '</div>'+
                '</div>',
          
          sertifikasi_halal: '<div class="form-group">'+
                  '<label>Deskripsi</label>'+
                  '<textarea class="form-control form-control-sm"></textarea>'+
                '</div>'+
                '<div class="form-group">'+
                  '<label>No Sertifikai</label>'+
                  '<input type="text" class="form-control form-control-sm">'+
                '</div>'
      };

      if (id_jenis == "1") {
        var template = template_form.pelatihan;
        $("#"+id_element).find(".section-intervensi-form").append(template);
      }
      else if(id_jenis == "3") {
        var template = template_form.sertifikasi_halal;
        $("#"+id_element).find(".section-intervensi-form").append(template);
      }
    }

  </script>
@endsection
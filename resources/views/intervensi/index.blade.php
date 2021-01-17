@extends('template.index')

@section('title')
    Data Intervensi
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
           <div class="row">
               <div class="col">
                   <div class="card-body">
                       <h3 class="card-title">Data Jenis Intervensi</h3>
                       <button class="btn btn-info btn-sm" id="btn-create"><span class="fa fa-plus"></span> Tambah Jenis</button><br><br>
                        <table id="table-intervensi" class="table table-bordered table-stripped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis Intervensi</th>
                                    <th class="text-center" style="width:22%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $i = 1;
                            ?>
                            @foreach ($data_intervensi as $intervensi)
                            <tr>
                                <td>{{ $i . "." }} </td>
                                <td>{{ $intervensi->jenis }}</td>
                                <td class="text-center" style="width: 22%">
                                    <button class="btn btn-warning btn-edit btn-sm" id="{{ $intervensi->id }}"><span class="fa fa-pen"></span> Edit</button>
                                    <button class="btn btn-danger btn-delete btn-sm" id="{{ $intervensi->id }}"><span class="fa fa-trash"></span> Delete</button>
                                </td>
                            </tr>  
                            <?php 
                                $i++;
                            ?>
                            @endforeach
                            </tbody>
                        </table>

                        <div id="section-modal">
                            @include('intervensi.modal-form')
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
    $('#table-intervensi').DataTable();

    $(document).on("click", "#btn-save", function(){
        var mode = "store";
        if ($("input[name='mode']").val() == "edit") {
            mode = "update";
        }
        $.ajax({
            "url": "/data_intervensi/"+mode,
            "type": "POST",
            "data": $("#form-add-intervensi").serialize(),
            "dataType": "json",
            success: function(data){
                if (data.status == "S") {
                    alert("Data berhasil disimpan");
                    location.reload();
                }
                else if(data.status == "E"){
                    alert(data.msg);
                }
            }
        })
    })

    $(document).on("click", ".btn-edit", function(){
        var id = $(this).attr('id')
        $.ajax({
            "url": "/data_intervensi/edit",
            "type": "POST",
            "data": {'id':id},
            success: function(res){
                $("#section-modal").html(res);
                $("#modal-head-title").html("Edit Jenis Intervensi");
                $("#ModalIntervensi").modal('show');
            }
        })
    });

    $("#btn-create").click(function(){
        $.ajax({
            "url": "/data_intervensi/create",
            "type": "POST",
            success: function(res){
                $("#section-modal").html(res);
                $("#modal-head-title").html("Tambah Jenis Intervensi");
                $("#ModalIntervensi").modal('show');
            }
        })
    });

    $(document).on("click", ".btn-delete", function(){
        var id = $(this).attr('id')
        if(confirm('Apakah anda yakin ingin menghapus?')){
            $.ajax({
                "url": "/data_intervensi/delete",
                "type": "POST",
                "dataType": "json",
                "data": {'id':id},
                success: function(res){
                    if (res == "success") {
                        alert("Data berhasil dihapus");
                        location.reload();
                    }
                }
            })
        }
    })
</script>
@endsection
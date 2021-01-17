@extends('template.index')

@section('title')
    Data UKM
@endsection

@section('content')
<div class="row">
 <div class="col-12 grid-margin stretch-card">
     <div class="card">
        <div class="row">
            <div class="col">
                <div class="card-body">
                    <h3 class="card-title">Data UKM</h3>
                    <a href="/data_ukm/create" class="btn btn-info btn-sm" id="btn-create"><span class="fa fa-plus"></span> Tambah UKM</a><br><br>
        
                    <table id="table-ukm" class="table table-bordered table-stripped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama UKM</th>
                                <th>Nama Pemilik UKM</th>
                                <th>NIK</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th class="text-center" style="width:22%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $i = 1;
                        ?>
                        @foreach ($data_ukm as $ukm)
                        <tr>
                            <td>{{ $i . "." }} </td>
                            <td>{{ $ukm->nama_ukm }}</td>
                            <td>{{ $ukm->nama_pemilik }}</td>
                            <td>{{ $ukm->nik }}</td>
                            <td>{{ $ukm->alamat }}</td>
                            <td>{{ $ukm->no_telp }}</td>
                            <td class="text-center" style="width: 22%">
                                <button class="btn btn-primary btn-edit btn-sm"><span class="fa fa-eye"></span> View</button>
                                <button class="btn btn-warning btn-edit btn-sm" id="{{ $ukm->id }}"><span class="fa fa-pen"></span> Edit</button>
                                <button class="btn btn-danger btn-delete btn-sm" id="{{ $ukm->id }}"><span class="fa fa-trash"></span> Delete</button>
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
        </div>
     </div>
 </div>
</div>

    
@endsection


@section('script')
<script>
    $('#table-ukm').DataTable();

    $(document).on("click", "#btn-save", function(){
        var mode = "store";
        if ($("input[name='mode']").val() == "edit") {
            mode = "update";
        }
        $.ajax({
            "url": "/data_ukm/"+mode,
            "type": "POST",
            "data": $("#form-add-ukm").serialize(),
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
            "url": "/data_ukm/edit",
            "type": "POST",
            "data": {'id':id},
            success: function(res){
                $("#section-modal").html(res);
                $("#modal-head-title").html("Edit Data UKM");
                $("#ModalUkm").modal('show');
            }
        })
    });

    $("#btn-create").click(function(){
        $.ajax({
            "url": "/data_ukm/create",
            "type": "POST",
            success: function(res){
                $("#section-modal").html(res);
                $("#modal-head-title").html("Tambah Data UKM");
                $("#ModalUkm").modal('show');
            }
        })
    });

    $(document).on("click", ".btn-delete", function(){
        var id = $(this).attr('id')
        if(confirm('Apakah anda yakin ingin menghapus?')){
            $.ajax({
                "url": "/data_ukm/delete",
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
@extends('layouts.index')

@section('title')
    Data Pengguna Website
@endsection

@section('content')
    <table id="table-user" class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Email</th>
                <th>Created At</th>
                <th class="text-center" style="width:22%">Aksi</th>
            </tr>
        </thead>
        <tbody>
		<?php 
			$i = 1;
		?>
		@foreach ($data_user as $user)
        <tr>
            <td>{{ $i . "." }} </td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td class="text-center" style="width: 22%">
                <button class="btn btn-danger btn-delete btn-sm" id="{{ $user->id }}"><span class="fa fa-trash"></span> Delete</button>
            </td>
		</tr>  
		<?php 
			$i++;
		?>
        @endforeach
        </tbody>
    </table>
@endsection


@section('script')
<script>
    $('#table-user').DataTable();

    $(document).on("click", ".btn-delete", function(){
        var id = $(this).attr('id')
        if(confirm('Apakah anda yakin ingin menghapus?')){
            $.ajax({
                "url": "/data_user/delete",
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
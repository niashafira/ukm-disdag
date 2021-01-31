@extends('template-metronics.index')

@section('title')
Form Referensi
@endsection

@section('content')
    <h3>Form Referensi</h3>
    <hr>
    <form id="form-ref">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Referensi ID</label>
                    <input autocomplete="off" type="text" class="form-control" name="ref_id" placeholder="Referensi Key">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Keterangan</label>
                    <input autocomplete="off" type="text" class="form-control" name="keterangan" placeholder="Keterangan">
                </div>
            </div>
        </div>
    </form>
    <h3>Detail Referensi</h3>
    <hr>
    <button id="add-detail-ref" style="margin-bottom: 2%" class="btn btn-sm btn-primary"><span class="fa fa-plus"></span> Tambah</button>
    <form id="form-detail-ref">
        <table class="table table-bordered" id="table-detail-ref">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Referensi Key</th>
                    <th>Referensi Value</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </form>

    <hr>

    <button id="btn-submit" style="float:right" class="btn btn-success btn-sm"><span class="fa fa-check"></span> Simpan</button>

    <div style="display: none">
        <table id="tmpl-detail-ref">
            <tbody>
            <tr id="__IDREF__">
                <td class="text-center">__NOREF__</td>
                <td>
                    <input type="text" class="form-control" name="ref_key[]" />
                </td>
                <td>
                    <input type="text" class="form-control" name="ref_val[]" />
                </td>
                <td>
                    <input type="text" class="form-control" name="keterangan[]" />
                </td>
                <td class="text-center">
                    <button data-index="__INDEX__" class="btn btn-sm btn-danger btn-delete-ref"><span class="fa fa-trash"></span></button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $("#add-detail-ref").click();
        });

        var index_detail_ref = 1;
        $("#add-detail-ref").click(function(){
            var tmpl_detail_ref = $("#tmpl-detail-ref tbody").html();
            tmpl_detail_ref = tmpl_detail_ref.replace(/__IDREF__/g, "detail-ref"+index_detail_ref);
            tmpl_detail_ref = tmpl_detail_ref.replace(/__NOREF__/g, index_detail_ref);
            tmpl_detail_ref = tmpl_detail_ref.replace(/__INDEX__/g, index_detail_ref);

            $("#table-detail-ref tbody").append(tmpl_detail_ref);

            index_detail_ref++;
        });

        $(document).on("click", ".btn-delete-ref", function(){
            var index = $(this).data("index");

            $("#detail-ref"+index).remove();
        });

        $("#btn-submit").click(function(){
            var ref_detail = [];

            var formserializeArray = $("#form-ref").serializeArray();
            var ref_head = {};
            jQuery.map(formserializeArray , function (n, i) {
                ref_head[n.name] = n.value;
            });

            $("#form-detail-ref input[name='ref_key[]']").each(function(i,o){
                ref_detail.push({
                    ref_id: ref_head.ref_id,
                    ref_key: $(o).val(),
                    ref_val: "",
                    keterangan: ""
                });
            });

            $("#form-detail-ref input[name='ref_val[]']").each(function(i,o){
                ref_detail[i].ref_val = $(o).val();
            });
            $("#form-detail-ref input[name='keterangan[]']").each(function(i,o){
                ref_detail[i].keterangan = $(o).val();
            });

            $.ajax({
                url: "/referensi/store",
                type: "POST",
                dataType: "JSON",
                data: {
                    referensi: ref_head,
                    detail_referensi: ref_detail
                },
                success: function(res){
                    if(res == "success"){
                        location.href("/referensi")
                    }
                }
            })
        });
    </script>
@endsection

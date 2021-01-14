<!-- Modal -->
<div class="modal fade" id="ModalIntervensi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-head-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-add-intervensi">
              <?php
                if(!isset($mode))
                  $mode = "create"
              ?>
                <input type="hidden" value="{{ $mode }}" name="mode">
                <div class="form-group">
                    <label>Jenis Intervensi</label>
                    <input type="text" name="jenis" class="form-control" placeholder="Jenis Intervensi" value="{{ isset($data->jenis) ? $data->jenis : '' }}">
                </div>
                @if($mode == "edit")
                  <input type="hidden", name="id" value="{{ $data->id }}" />
                @endif
            </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" id="btn-save" class="btn btn-primary btn-save">Simpan</button>
        </div>
      </div>
    </div>
</div>


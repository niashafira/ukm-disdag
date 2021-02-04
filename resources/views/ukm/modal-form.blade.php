
<div class="modal fade" id="ModalUkm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-head-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="form-add-ukm">
              <?php
                if(!isset($mode))
                  $mode = "create"
              ?>
                <input type="hidden" value="{{ $mode }}" name="mode">
                <div class="form-group">
                    <label>Nama UKM</label>
                    <input type="text" name="nama_ukm" class="form-control" placeholder="Nama UKM" value="{{ isset($data->nama_ukm) ? $data->nama_ukm : '' }}">
                </div>
                <div class="form-group">
                    <label>Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" class="form-control" placeholder="Nama Pemilik UKM" value="{{ isset($data->nama_pemilik) ? $data->nama_pemilik : '' }}">
                </div>
                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control" placeholder="NIK Pemilik UKM" value="{{ isset($data->nik) ? $data->nik : '' }}">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Alamat Pemilik UKM" value="{{ isset($data->alamat) ? $data->alamat : '' }}">
                </div>
                <div class="form-group">
                    <label>No Telp</label>
                    <input type="text" name="no_telp" class="form-control" placeholder="No Telp Pemilik UKM" value="{{ isset($data->no_telp) ? $data->no_telp : '' }}">
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
@extends('template-metronics.index')

@section('title')
Data UKM
@endsection

@section('style')
    <link href="{{asset('template-metronics/assets/css/pages/wizard/wizard-1.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
  <?php
      if(!isset($mode))
      $mode = "create"
  ?>

<div id="tmpl-intervensi" style="display: none">
    <form id="__INDEX__">
        <div class="row" style="margin-top:3%" id="__FORMINDEX__">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Jenis Intervensi</label>
                    <select data-index="__INDEX__" class="form-control-solid form-control form-control-sm select-intervensi">
                        <option selected disabled>--Pilih Jenis Intervensi--</option>
                        @foreach ($jenis_intervensi as $intervensi)
                            <option value="{{$intervensi->id}}">{{$intervensi->jenis}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-12 d-flex justify-content-center" style="padding-top:2%">
            <button type="button" class="btn btn-md btn-danger"><span class="fa fa-trash"></span></button>
        </div>
    </div>
    <hr>
</div>

<div id="tmpl-intervensi-pelatihan" style="display: none">
    <div class="col-md-4">
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" class="form-control form-control-solid" name="no_telp" placeholder="Deskripsi" />
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" class="form-control form-control-solid" name="lokasi" placeholder="Deskripsi" />
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" class="form-control form-control-solid" name="no_telp" placeholder="Deskripsi" />
        </div>
    </div>
</div>

<div id="tmpl-intervensi-bazar" style="display: none">
    <div class="col-md-5">
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" class="form-control form-control-solid" name="no_telp" placeholder="Deskripsi" />
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" class="form-control form-control-solid" name="lokasi" placeholder="Lokasi" />
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" class="form-control form-control-solid" name="tanggal_mulai" placeholder="Tanggal Mulai" />
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>Tanggal Selesai</label>
            <input type="date" class="form-control form-control-solid" name="tanggal_selesai" placeholder="Tanggal Selesai" />
        </div>
    </div>
</div>

<div id="tmpl-intervensi-sertifikasi" style="display: none">
    <div class="col-md-4">
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" class="form-control form-control-solid" name="no_telp" placeholder="Deskripsi" />
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>No Sertifikasi</label>
            <input type="text" class="form-control form-control-solid" name="no_telp" placeholder="No Sertifikasi" />
        </div>
    </div>
</div>

<div id="tmpl-intervensi-pemasaran" style="display: none">
    <div class="col">
        <div class="form-group">
            <label>Deskripsi</label>
            <input type="text" class="form-control form-control-solid" name="no_telp" placeholder="Deskripsi" />
        </div>
    </div>
    <div class="col">
        <div class="form-group">
            <label>Lokasi</label>
            <input type="text" class="form-control form-control-solid" name="no_telp" placeholder="No Sertifikasi" />
        </div>
    </div>
</div>

  <div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        <div class="card card-custom">
            <div class="card-body p-0">
                <!--begin::Wizard-->
                <div class="wizard wizard-1" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">
                    <!--begin::Wizard Nav-->
                    <div class="wizard-nav border-bottom">
                        <div class="wizard-steps p-8 p-lg-10">
                            <!--begin::Wizard Step 1 Nav-->
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-bus-stop"></i>
                                    <h3 class="wizard-title">1. Profile UKM</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <!--end::Wizard Step 1 Nav-->
                            <!--begin::Wizard Step 2 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-list"></i>
                                    <h3 class="wizard-title">2. Detail Intervensi</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <!--end::Wizard Step 2 Nav-->

                            <!--begin::Wizard Step 5 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-globe"></i>
                                    <h3 class="wizard-title">5. Review dan Submit</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow last">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <!--end::Wizard Step 5 Nav-->
                        </div>
                    </div>
                    <!--end::Wizard Nav-->
                    <!--begin::Wizard Body-->
                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-7">
                            <!--begin::Wizard Form-->
                            <form class="form" id="kt_form">
                                <!--begin::Wizard Step 1-->
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <h3 class="mb-10 font-weight-bold text-dark">Data UKM</h3>
                                    <!--begin::Input-->

                                    <!--end::Input-->
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>Nama UKM</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="nama_ukm" placeholder="Nama UKM" />
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="col-xl-6">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>Nama Pemilik</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="nama_pemilik" placeholder="Nama Pemilik" />
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="nik" placeholder="NIK"/>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                        <div class="col-xl-6">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>No. Telp</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="no_telp" placeholder="No. Telp" />
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <!--begin::Input-->
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <textarea class="form-control form-control-solid form-control-lg" name="alamat" > </textarea>
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>
                                </div>
                                <!--end::Wizard Step 1-->


                                <!--begin::Wizard Step 2-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h4 class="mb-10 font-weight-bold text-dark">Detail Intervensi UKM</h4>
                                    <button id="add-intervensi" type="button" class="btn btn-md btn-success"><span class="fa fa-plus"></span> Tambah Intervensi</button>
                                    <!--begin::Input-->
                                    <div id="section-intervensi"></div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Wizard Step 2-->


                                <!--begin::Wizard Step 5-->
                                <div class="pb-5" data-wizard-type="step-content">
                                    <!--begin::Section-->
                                    <h4 class="mb-10 font-weight-bold text-dark">Review your Details and Submit</h4>
                                    <h6 class="font-weight-bolder mb-3">Current Address:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <div>Address Line 1</div>
                                        <div>Address Line 2</div>
                                        <div>Melbourne 3000, VIC, Australia</div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <!--end::Section-->
                                    <!--begin::Section-->
                                    <h6 class="font-weight-bolder mb-3">Delivery Details:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <div>Package: Complete Workstation (Monitor, Computer, Keyboard &amp; Mouse)</div>
                                        <div>Weight: 25kg</div>
                                        <div>Dimensions: 110cm (w) x 90cm (h) x 150cm (L)</div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <!--end::Section-->
                                    <!--begin::Section-->
                                    <h6 class="font-weight-bolder mb-3">Delivery Service Type:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <div>Overnight Delivery with Regular Packaging</div>
                                        <div>Preferred Morning (8:00AM - 11:00AM) Delivery</div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <!--end::Section-->
                                    <!--begin::Section-->
                                    <h6 class="font-weight-bolder mb-3">Delivery Address:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <div>Address Line 1</div>
                                        <div>Address Line 2</div>
                                        <div>Preston 3072, VIC, Australia</div>
                                    </div>
                                    <!--end::Section-->
                                </div>
                                <!--end::Wizard Step 5-->
                                <!--begin::Wizard Actions-->
                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                    </div>
                                    <div>
                                        <button id="btn-submit" type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                        <button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Next</button>
                                    </div>
                                </div>
                                <!--end::Wizard Actions-->
                            </form>
                            <!--end::Wizard Form-->
                        </div>
                    </div>
                    <!--end::Wizard Body-->
                </div>
                <!--end::Wizard-->
            </div>
            <!--end::Wizard-->
        </div>
    </div>
    <!--end::Container-->
</div>

@endsection

@section('script')
    <script src="{{asset('template-metronics/assets/js/pages/custom/wizard/wizard-1.js')}}"></script>

  <script>
      
    var listIntervensi = {!! json_encode($jenis_intervensi) !!};
    console.log(listIntervensi);
    var index_intervensi = 1;
    $("#add-intervensi").click(function(){
      var tmpl = $("#tmpl-intervensi").html();
      tmpl = tmpl.replace(/__INDEX__/g, "intervensi"+index_intervensi);
      tmpl = tmpl.replace(/__FORMINDEX__/g, "section-intervensi"+index_intervensi);
      $("#section-intervensi").append(tmpl);
      index_intervensi++;
    });

    $(document).on("change",".select-intervensi", function(){
        $("#section-"+id_element).html("");
      var id_element = $(this).data("index");
      var id_jenis = $(this).val();
      var tmpl_form;
      if (id_jenis == 1) {
        tmpl_form = $("#tmpl-intervensi-pelatihan").html();
      }
      else if (id_jenis == 3 || id_jenis == 4) {
        tmpl_form = $("#tmpl-intervensi-sertifikasi").html();
      }
      else if (id_jenis == 2) {
        tmpl_form = $("#tmpl-intervensi-bazar").html();
      }
      else if (id_jenis == 7) {
        tmpl_form = $("#tmpl-intervensi-pemasaran").html();
      }

      $("#section-"+id_element).append(tmpl_form);
    });

    $("#btn-submit").click(function(){
        var data = $("#intervensi1").serialize();
        console.log(data);
    });

  </script>
@endsection

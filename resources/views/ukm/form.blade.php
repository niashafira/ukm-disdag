@extends('template-metronics.index')

@section('title')
Form UKM
@endsection

@section('style')
    <link href="{{asset('template-metronics/assets/css/pages/wizard/wizard-2.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .ui-datepicker-calendar {
            display: none;
        }
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card card-custom">
            <div class="card-body p-0">
                <!--begin: Wizard-->
                <div class="wizard wizard-2" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">
                    <!--begin: Wizard Nav-->
                    <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-steps">
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Profil UKM</h3>
                                        <div class="wizard-desc">Atur Detail Profil UKM</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 1 Nav-->
                            <!--begin::Wizard Step 2 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Compass.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M12,21 C7.02943725,21 3,16.9705627 3,12 C3,7.02943725 7.02943725,3 12,3 C16.9705627,3 21,7.02943725 21,12 C21,16.9705627 16.9705627,21 12,21 Z M14.1654881,7.35483745 L9.61055177,10.3622525 C9.47921741,10.4489666 9.39637436,10.592455 9.38694497,10.7495509 L9.05991526,16.197949 C9.04337012,16.4735952 9.25341309,16.7104632 9.52905936,16.7270083 C9.63705011,16.7334903 9.74423017,16.7047714 9.83451193,16.6451626 L14.3894482,13.6377475 C14.5207826,13.5510334 14.6036256,13.407545 14.613055,13.2504491 L14.9400847,7.80205104 C14.9566299,7.52640477 14.7465869,7.28953682 14.4709406,7.27299168 C14.3629499,7.26650974 14.2557698,7.29522855 14.1654881,7.35483745 Z" fill="#000000" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Ijin Usaha/Edar</h3>
                                        <div class="wizard-desc">Atur Ijin Usaha dan Edar</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 2 Nav-->
                            <!--begin::Wizard Step 3 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Thunder-move.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M16.3740377,19.9389434 L22.2226499,11.1660251 C22.4524142,10.8213786 22.3592838,10.3557266 22.0146373,10.1259623 C21.8914367,10.0438285 21.7466809,10 21.5986122,10 L17,10 L17,4.47708173 C17,4.06286817 16.6642136,3.72708173 16.25,3.72708173 C15.9992351,3.72708173 15.7650616,3.85240758 15.6259623,4.06105658 L9.7773501,12.8339749 C9.54758575,13.1786214 9.64071616,13.6442734 9.98536267,13.8740377 C10.1085633,13.9561715 10.2533191,14 10.4013878,14 L15,14 L15,19.5229183 C15,19.9371318 15.3357864,20.2729183 15.75,20.2729183 C16.0007649,20.2729183 16.2349384,20.1475924 16.3740377,19.9389434 Z" fill="#000000" />
                                                    <path d="M4.5,5 L9.5,5 C10.3284271,5 11,5.67157288 11,6.5 C11,7.32842712 10.3284271,8 9.5,8 L4.5,8 C3.67157288,8 3,7.32842712 3,6.5 C3,5.67157288 3.67157288,5 4.5,5 Z M4.5,17 L9.5,17 C10.3284271,17 11,17.6715729 11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L4.5,20 C3.67157288,20 3,19.3284271 3,18.5 C3,17.6715729 3.67157288,17 4.5,17 Z M2.5,11 L6.5,11 C7.32842712,11 8,11.6715729 8,12.5 C8,13.3284271 7.32842712,14 6.5,14 L2.5,14 C1.67157288,14 1,13.3284271 1,12.5 C1,11.6715729 1.67157288,11 2.5,11 Z" fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Permodalan/Peminjaman</h3>
                                        <div class="wizard-desc">Atur Detail Permodalan dan Peminjaman</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 3 Nav-->
                            <!--begin::Wizard Step 4 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Map/Position.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M19,11 L21,11 C21.5522847,11 22,11.4477153 22,12 C22,12.5522847 21.5522847,13 21,13 L19,13 C18.4477153,13 18,12.5522847 18,12 C18,11.4477153 18.4477153,11 19,11 Z M3,11 L5,11 C5.55228475,11 6,11.4477153 6,12 C6,12.5522847 5.55228475,13 5,13 L3,13 C2.44771525,13 2,12.5522847 2,12 C2,11.4477153 2.44771525,11 3,11 Z M12,2 C12.5522847,2 13,2.44771525 13,3 L13,5 C13,5.55228475 12.5522847,6 12,6 C11.4477153,6 11,5.55228475 11,5 L11,3 C11,2.44771525 11.4477153,2 12,2 Z M12,18 C12.5522847,18 13,18.4477153 13,19 L13,21 C13,21.5522847 12.5522847,22 12,22 C11.4477153,22 11,21.5522847 11,21 L11,19 C11,18.4477153 11.4477153,18 12,18 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="2" />
                                                    <path d="M12,17 C14.7614237,17 17,14.7614237 17,12 C17,9.23857625 14.7614237,7 12,7 C9.23857625,7 7,9.23857625 7,12 C7,14.7614237 9.23857625,17 12,17 Z M12,19 C8.13400675,19 5,15.8659932 5,12 C5,8.13400675 8.13400675,5 12,5 C15.8659932,5 19,8.13400675 19,12 C19,15.8659932 15.8659932,19 12,19 Z" fill="#000000" fill-rule="nonzero" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Sertifikasi Halal/Merek</h3>
                                        <div class="wizard-desc">Atur Sertifikasi Halal dan Merek</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 4 Nav-->
                            <!--begin::Wizard Step 5 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Credit-card.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <rect fill="#000000" opacity="0.3" x="2" y="5" width="20" height="14" rx="2" />
                                                    <rect fill="#000000" x="2" y="8" width="20" height="3" />
                                                    <rect fill="#000000" opacity="0.3" x="16" y="14" width="4" height="2" rx="1" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Omset</h3>
                                        <div class="wizard-desc">Atur detail omset bulanan</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 5 Nav-->
                            <!--begin::Wizard Step 6 Nav-->
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-wrapper">
                                    <div class="wizard-icon">
                                        <span class="svg-icon svg-icon-2x">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Like.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path d="M9,10 L9,19 L10.1525987,19.3841996 C11.3761964,19.7920655 12.6575468,20 13.9473319,20 L17.5405883,20 C18.9706314,20 20.2018758,18.990621 20.4823303,17.5883484 L21.231529,13.8423552 C21.5564648,12.217676 20.5028146,10.6372006 18.8781353,10.3122648 C18.6189212,10.260422 18.353992,10.2430672 18.0902299,10.2606513 L14.5,10.5 L14.8641964,6.49383981 C14.9326895,5.74041495 14.3774427,5.07411874 13.6240179,5.00562558 C13.5827848,5.00187712 13.5414031,5 13.5,5 L13.5,5 C12.5694044,5 11.7070439,5.48826024 11.2282564,6.28623939 L9,10 Z" fill="#000000" />
                                                    <rect fill="#000000" opacity="0.3" x="2" y="9" width="5" height="11" rx="1" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </div>
                                    <div class="wizard-label">
                                        <h3 class="wizard-title">Submit!</h3>
                                        <div class="wizard-desc">Review dan Submit</div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Wizard Step 6 Nav-->
                        </div>
                    </div>
                    <!--end: Wizard Nav-->
                    <!--begin: Wizard Body-->
                    <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
                        <!--begin: Wizard Form-->
                        <div class="row">
                            <div class="offset-xxl-2 col-xxl-8">
                                <form class="form" id="kt_form">
                                    <!--begin: Wizard Step 1-->
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        <h4 class="mb-10 font-weight-bold text-dark">Profil UKM</h4>

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Nama Pemilik</label>
                                                    <input v-model="ukm.nama_pemilik" type="text" class="form-control form-control-solid form-control-lg" name="namaPemilik" placeholder="Nama Pemilik" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>
                                                        NIK Pemilik
                                                        <span style="cursor: pointer" v-on:click="openModalDuplicate()" v-if="this.statusDuplicate == true" class="badge badge-warning"><span class="fa flaticon-warning"></span> NIK sudah pernah terdaftar. Klik disini </span>
                                                        <span v-if="this.statusDuplicate == false" class="badge badge-success"><span class="fa flaticon2-check-mark"></span> NIK belum pernah terdaftar. </span>
                                                    </label>
                                                    <input v-on:focusout="checkDuplicate()" v-model="ukm.nik" type="text" class="form-control form-control-solid form-control-lg" name="nikPemilik" placeholder="NIK Pemilik" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Nama Usaha</label>
                                                    <input v-model="ukm.nama_usaha" type="text" class="form-control form-control-solid form-control-lg" name="namaUsaha" placeholder="Nama Usaha" />
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>Jenis Produksi</label>
                                                    <input v-model="ukm.jenis_produksi" type="text" class="form-control form-control-solid form-control-lg" name="jenisProduksi" placeholder="Jenis Produksi" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Alamat Usaha</label>
                                            <input v-model="ukm.alamat" type="text" class="form-control form-control-solid form-control-lg" name="alamatUsaha" placeholder="Alamat Usaha" />
                                        </div>

                                        <div class="form-group">
                                            <label>Jangkauan Pemasaran</label>
                                            <input v-model="ukm.jangkauan_pemasaran" type="text" class="form-control form-control-solid form-control-lg" name="jangkauanPemasaran" placeholder="Jangkauan Pemasaran" />
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>No Telepon</label>
                                                    <input v-model="ukm.no_telp" type="tel" class="form-control form-control-solid form-control-lg" name="phone" placeholder="No Telepon" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input v-model="ukm.email" type="email" class="form-control form-control-solid form-control-lg" name="email" placeholder="Email" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 1-->
                                    <!--begin: Wizard Step 2-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-10 font-weight-bold text-dark">Atur Ijin Usaha dan Ijin Edar</h4>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Nomor SIUP</label>
                                                    <input v-model="ukm.no_siup" type="text" class="form-control form-control-solid form-control-lg" name="noSiup" placeholder="Nomor SIUP" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Nomor NIB</label>
                                                    <input v-model="ukm.no_nib" type="text" class="form-control form-control-solid form-control-lg" name="noNib" placeholder="Nomor NIB" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Nomor TDP</label>
                                                    <input v-model="ukm.no_tdp" type="text" class="form-control form-control-solid form-control-lg" name="noTdp" placeholder="Nomor TDP" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Nomor IUMK</label>
                                                    <input v-model="ukm.no_iumk" type="text" class="form-control form-control-solid form-control-lg" name="noIumk" placeholder="Nomor IUMK" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Nomor PIRT</label>
                                                    <input v-model="ukm.no_pirt" type="text" class="form-control form-control-solid form-control-lg" name="noPirt" placeholder="Nomor PIRT" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Nomor BPOM</label>
                                                    <input v-model="ukm.no_bpom" type="text" class="form-control form-control-solid form-control-lg" name="noBpom" placeholder="Nomor BPOM" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 2-->
                                    <!--begin: Wizard Step 3-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-10 font-weight-bold text-dark">Atur Permodalan dan Peminjaman</h4>
                                        <!--begin::Select-->
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Jumlah Pemodalan (Rp)</label>
                                                    <input v-model="ukm.jumlah_pemodalan" type="number" class="form-control form-control-solid form-control-lg" name="jmlModal" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Sumber</label>
                                                    <input v-model="ukm.sumber_pemodalan" type="text" class="form-control form-control-solid form-control-lg" name="sumberModal" placeholder="Sumber Permodalan" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <!--end::Select-->
                                        <!--begin::Select-->
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Jumlah Pinjaman (Rp)</label>
                                                    <input v-model="ukm.jumlah_pinjaman" type="number" class="form-control form-control-solid form-control-lg" name="jmlPinjaman" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>Sumber</label>
                                                    <input v-model="ukm.sumber_pinjaman" type="text" class="form-control form-control-solid form-control-lg" name="sumberPinjaman" placeholder="Sumber Pinjaman" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                        <!--end::Select-->
                                    </div>
                                    <!--end: Wizard Step 3-->
                                    <!--begin: Wizard Step 4-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-10 font-weight-bold text-dark">Atur Sertifikasi Halal dan Merek</h4>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>No Sertifikasi Halal</label>
                                                    <input v-model="ukm.no_sertifikasi_halal" type="text" class="form-control form-control-solid form-control-lg" name="noSertifikasiHalal" placeholder="No Sertifikasi Halal" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group">
                                                    <label>No Sertifikasi Merek</label>
                                                    <input v-model="ukm.no_sertifkasi_merek" type="text" class="form-control form-control-solid form-control-lg" name="noSertifikasiMerek" placeholder="No Sertifikasi Merek" />
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 4-->
                                    <!--begin: Wizard Step 5-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <h4 class="mb-10 font-weight-bold text-dark">Atur Omset Bulanan</h4>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <button v-on:click="tambahOmset()" style="margin-bottom:3%" type="button" class="btn btn-sm btn-info"><span class="fa fa-plus"></span> Tambah</button>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tanggal</th>
                                                            <th>Jumlah (Rp)</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(omset, index) in omset" :key="index">
                                                            <td class="text-center">@{{ index + 1 }}</td>
                                                            <td>
                                                                <input v-model="omset.tanggal" :id="'datepicker' + index" type="text" class="form-control form-control-solid" />
                                                                {{-- <input v-model="omset.tanggal" :id="'datepicker' + index" class="form-control form-control-solid" /> --}}
                                                            </td>
                                                            <td>
                                                                <input v-model.number="omset.jumlah" type="number" class="form-control form-control-solid" />
                                                            </td>
                                                            <td class="text-center">
                                                                <button class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end: Wizard Step 5-->
                                    <!--begin: Wizard Step 6-->
                                    <div class="pb-5" data-wizard-type="step-content">
                                        <!--begin::Section-->
                                        <h4 class="mb-10 font-weight-bold text-dark">Review Data dan Submit</h4>

                                        <!--end::Section-->
                                    </div>
                                    <!--end: Wizard Step 6-->
                                    <!--begin: Wizard Actions-->
                                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                        <div class="mr-2">
                                            <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Sebelumnya</button>
                                        </div>
                                        <div>
                                            <button v-on:click="simpan()" type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Simpan</button>
                                            <button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Selanjutnya</button>
                                        </div>
                                    </div>
                                    <!--end: Wizard Actions-->
                                </form>
                            </div>
                            <!--end: Wizard-->
                        </div>
                        <!--end: Wizard Form-->
                    </div>
                    <!--end: Wizard Body-->
                </div>
                <!--end: Wizard-->
            </div>
        </div>
    </div>
</div>

<div id="modal-duplicate" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UKM dengan NIK : @{{ duplicate.nik }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body table-responsive">
                <table id="table-ukm" class="table table-bordered">
                    <thead class="bg-primary">
                    <tr>
                        <th class="text-white">No</th>
                        <th class="text-white">NIK</th>
                        <th class="text-white">Nama UKM</th>
                        <th class="text-white">Pemilik</th>
                        <th class="text-white">Alamat</th>
                        <th class="text-white">No Telfon</th>
                    </tr>
                    </thead>
                    <tr v-for="(ukm, index) in duplicate.data" :key="index">
                        <td>@{{ index + 1 }}</td>
                        <td>@{{ ukm.nik }}</td>
                        <td>@{{ ukm.nama_usaha }}</td>
                        <td>@{{ ukm.nama_pemilik }}</td>
                        <td>@{{ ukm.alamat }}</td>
                        <td>@{{ ukm.no_telp }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script src="{{asset('template-metronics/assets/js/pages/custom/wizard/wizard-2.js')}}"></script>

    @include('ukm.formJs')
@endsection

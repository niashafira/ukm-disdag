@if (Route::is('intervensi') || Route::is('ukm'))

    <!--begin::Header-->
    <div id="kt_header" class="header header-fixed">
        <!--begin::Header Wrapper-->
        <div class="header-wrapper rounded-top-xl d-flex flex-grow-1 align-items-center">
            <!--begin::Container-->
            <div class="container-fluid d-flex align-items-center justify-content-end justify-content-lg-between flex-wrap">
                <!--begin::Menu Wrapper-->
                <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                    <!--begin::Menu-->
                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                        <!--begin::Nav-->
                        <ul class="menu-nav">

                            <li class="menu-item menu-item-submenu menu-item-rel {{ Route::is('ukm') ? 'menu-item-here' : '' }}" data-menu-toggle="click" aria-haspopup="true">
                                <a href="/ukm" class="menu-link">
                                    <span class="menu-text">Data UKM</span>
                                    <span class="menu-desc"></span>
                                </a>
                            </li>

                            <li class="menu-item menu-item-submenu menu-item-rel {{ Route::is('intervensi') ? 'menu-item-here' : '' }}" data-menu-toggle="click" aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="menu-text">Data Intervensi</span>
                                    <span class="menu-desc"></span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="/intervensi/pelatihan" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Pelatihan</span>
                                            </a>
                                        </li>
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="/intervensi/pameran" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Pameran/Bazar</span>
                                            </a>
                                        </li>
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="/intervensi/pemasaran" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Pemasaran</span>
                                            </a>
                                        </li>
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="/intervensi/SertifikasiHalal" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Sertifikasi Halal</span>
                                            </a>
                                        </li>
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="/intervensi/SertifikasiMerek" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Sertifikasi Merek</span>
                                            </a>
                                        </li>
                                        <li class="menu-item" aria-haspopup="true">
                                            <a href="/intervensi/lainnya" class="menu-link">
                                                <i class="menu-bullet menu-bullet-dot">
                                                    <span></span>
                                                </i>
                                                <span class="menu-text">Lainnya</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            {{-- <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
                                <a href="/referensi" class="menu-link">
                                    <span class="menu-text">Data Referensi</span>
                                    <span class="menu-desc"></span>
                                </a>
                            </li>
                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">
                                <a href="/data_user" class="menu-link">
                                    <span class="menu-text">Data User</span>
                                    <span class="menu-desc"></span>
                                </a>
                            </li> --}}
                        </ul>
                        <!--end::Nav-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu Wrapper-->

            </div>
            <!--end::Container-->
        </div>
        <!--end::Header Wrapper-->
    </div>

@endif

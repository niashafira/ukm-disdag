<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Manajemen Data UKM</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item active">
        <a class="nav-link" href="{{url('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> --}}

    <li class="nav-item active">
        <a class="nav-link" href="{{url('data_ukm')}}">
            <i class="fas fa-fw fa-list"></i>
            <span>Data UKM</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{url('data_intervensi')}}">
            <i class="fas fa-fw fa fa-folder"></i>
            <span>Data Intervensi</span></a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{url('data_user')}}">
            <i class="fas fa-fw fa fa-users"></i>
            <span>Data Users</span></a>
    </li>


</ul>
<!-- End of Sidebar -->
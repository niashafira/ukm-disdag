<div class="horizontal-menu">
    <nav class="navbar top-navbar col-lg-12 col-12 p-0">
      <div class="container-fluid">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">
         
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
              <h3 style="font-family: fantasy; color: #525656;">Managemen Data UKM</h3>
          </div>
          <ul class="navbar-nav navbar-nav-right">
              
              <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                  <span class="nav-profile-name">Admin</span>
                  <span class="online-status"></span>
                  <img src="{{asset('template/images/faces/face28.png')}}" alt="profile"/>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item">
                      <i class="mdi mdi-logout text-primary"></i>
                      Logout
                    </a>
                </div>
              </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </div>
    </nav>
    <nav class="bottom-navbar">
      <div class="container">
          <ul class="nav page-navigation">
            <li class="nav-item">
              <a class="nav-link" href="index.html">
                <i class="mdi mdi-file-document-box menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
                <a href="/data_ukm" class="nav-link">
                  <i class="mdi mdi-chart-areaspline menu-icon"></i>
                  <span class="menu-title">Data UKM</span>
                  <i class="menu-arrow"></i>
                </a>
            </li>
            <li class="nav-item">
                <a href="/data_intervensi" class="nav-link">
                  <i class="mdi mdi-finance menu-icon"></i>
                  <span class="menu-title">Data Intervensi</span>
                  <i class="menu-arrow"></i>
                </a>
            </li>
            <li class="nav-item">
              <a href="/data_user" class="nav-link">
                <i class="fa fa-user menu-icon"></i>
                <span class="menu-title">Data User</span>
                <i class="menu-arrow"></i>
              </a>
          </li>
            
          </ul>
      </div>
    </nav>
  </div>
@php
  $uri = request()->segment(2);
@endphp 
<style>
  #logo-image {
    width: 50px;
    height: auto;
  }

  .app-brand.demo {
    display: flex;
    justify-content: center; /* Adjust for center alignment */
    align-items: center;
    height: 100%; /* Ensure it takes the full height of the menu */
  }

  body {
      margin: 0;
      font-family: "Times New Roman", Times, serif;
      color: #000; /* Set text color to black */
  }

  .main {
      position: relative;
      width: 100%;
      height: auto;
      overflow: hidden;
  }

  .col-md-12 {
      position: relative;
      width: 200%;
      height: auto;
      display: flex;
      animation: slideImages 10s linear infinite; /* Change duration to 20s */
      transition: transform 0.01s ease; /* Smooth transition */
  }

  .col-md-12 img {
      width: 50%;
      max-height: 700px;
      margin-top: 50px;
      user-select: none; /* Prevent images from being selected */
      pointer-events: none; /* Disable pointer events on images */
  }
</style>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            @if (!empty($satu->logos))
              <img src="{{ asset('assets/img/custom/' . $satu->logos) }}" alt="Login Icon" class="img-fluid mb-3 logo-login" style="max-width: 150px;">
            @endif
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>
          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-header">MAIN MENU</li>
            <li class="menu-item {{ $uri == 'dashboard' ? 'active' : '' }}">
    <a href="{{ url('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Analytics">Dashboard</div>
    </a>
</li>
<li class="menu-item {{ $uri == 'menu' ? 'active' : '' }}">
    <a href="{{ url('Menu') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-food-menu"></i>
        <div data-i18n="Analytics">Menu</div>
    </a>
</li>
<li class="menu-item {{ $uri == 'menu' ? 'active' : '' }}">
    <a href="{{ url('transaksi') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cart"></i>
        <div data-i18n="Analytics">transaksi</div>
    </a>
</li>
<li class="menu-item {{ $uri == 'menu' ? 'active' : '' }}">
    <a href="{{ url('meja') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-table"></i>
        <div data-i18n="Analytics">meja</div>
    </a>
</li>
<li class="menu-item {{ $uri == 'menu' ? 'active' : '' }}">
    <a href="{{ url('member') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-circle"></i>
        <div data-i18n="Analytics">membership</div>
    </a>
</li>
<li class="menu-item {{ $uri == 'menu' ? 'active' : '' }}">
    <a href="{{ url('Voucher') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-purchase-tag"></i>
        <div data-i18n="Analytics">Voucher</div>
    </a>
</li>
<li class="menu-item {{ $uri == 'menu' ? 'active' : '' }}">
    <a href="{{ url('scan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-scan"></i>
        <div data-i18n="Analytics">Scan</div>
    </a>
</li>
            @php
              $userLevel = session()->get('Level');
              $allowedLevels = ['admin'];
            @endphp

            @if (in_array($userLevel, $allowedLevels))
              <li class="menu-header">ADMIN MENU</li>
              <li class="menu-item {{ in_array(request()->segment(2), ['User', 'Aduser', 'UpUser']) ? 'active' : '' }}">
                <a href="{{ url('User') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-notepad"></i>
                  <div data-i18n="Layouts">User</div>
                </a>
              </li>
              <li class="menu-item {{ request()->segment(2) == 'setting' ? 'active' : '' }}">
                <a href="{{ url('setting/1') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-cog"></i>
                  <div data-i18n="Layouts">Setting</div>
                </a>
              </li>
              <li class="menu-item {{ request()->segment(2) == 'activity_log' ? 'active' : '' }}">
                <a href="{{ url('activity_log') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-notepad"></i>
                  <div data-i18n="Layouts">Activity Log</div>
                </a>
              </li>
            @endif

            <li class="menu-header">LOG OUT</li>
            <li class="menu-item">
              <a href="{{ url('') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-log-in-circle"></i>
                <div data-i18n="Layouts">Log out</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <nav class="layout-navbar container-xxxxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <!-- Your search code goes here -->
            </div>
          </nav>
          <!-- / Navbar -->

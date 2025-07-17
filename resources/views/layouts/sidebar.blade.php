<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('template/img/logo.png') }}" style="height: 25px; width: auto;">
        </div>
        <div class="sidebar-brand-text mx-3" style="white-space: nowrap; font-size: 1.5rem; max-width: 120px; overflow: hidden; text-overflow: ellipsis; font-family: 'Segoe UI', 'Arial', 'sans-serif'; font-weight: 700;">
            KPI
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @can('dashboard-view')
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>My Dashboard</span></a>
    </li>
    @endcan

    @role('admin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Kelola Karyawan
    </div>
    <li class="nav-item {{ request()->is('user') ? 'active' : '' }}">
        <a class="nav-link" href="/user">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Karyawan</span>
        </a>
    </li>
    @endrole

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Kelola KPI
    </div>
    @can('kpimetrics-view')
    <li class="nav-item {{ request()->is('kpimetrics*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kpimetrics.index') }}">
            <i class="fas fa-fw fa-key"></i>
            <span>Data KPI</span>
        </a>
    </li>
    @endcan

    @role('karyawan')
    <li class="nav-item {{ request()->is('hitungkpi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('hitungkpi.index') }}">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Hitung KPI</span>
        </a>
    </li>
    @endrole
    @role('admin')
    <li class="nav-item {{ request()->is('kpirecords*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kpirecords.index') }}">
            <i class="fas fa-fw fa-calculator"></i>
            <span>KPI Record</span>
        </a>
    </li>
    @endrole

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Pusat Bantuan
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-question-circle"></i>
            <span>Bantuan</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Anda bingung???</h6>
                <a class="collapse-item" href="{{ route('faq.index') }}">Panduan dan Kontak kami</a>
            </div>
        </div>
    </li>

    @role('karyawan')
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Reports
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Laporan</span>
        </a>
    </li>
    @endrole

    @role('admin')
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Reports
    </div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.admin') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Resume KPI</span>
        </a>
    </li>
    @endrole

    <!-- ✅ Footer Sidebar -->
    <div class="sidebar-footer text-center mt-auto p-3" style="font-size: 0.75rem; color: rgba(255,255,255,0.7); border-top: 1px solid rgba(255,255,255,0.2);">
        <span>&copy; {{ date('Y') }} KPI Calculating AB</span><br>
        <span style="font-size: 0.7rem;">v1.0.0</span>
    </div>

</ul>

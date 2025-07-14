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
    <!-- Heading -->
    <div class="sidebar-heading">
        Kelola Karyawan
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    
    <li class="nav-item {{ request()->is('user') ? 'active' : '' }}">
        <a class="nav-link" href="/user">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Karyawan</span>
        </a>
    </li>
    @endrole

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
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

    <!-- Heading -->
    <div class="sidebar-heading">
        FAQ
    </div>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('faq.index') }}">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Panduan</span>
        </a>
    </li>
    

</ul>
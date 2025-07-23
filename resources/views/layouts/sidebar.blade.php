<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="border-radius: 0 30px 30px 0;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('template/img/logo.png') }}" style="height: 25px; width: auto;">
        </div>
        <div class="sidebar-brand-text mx-3"
            style="white-space: nowrap; font-size: 1.5rem; max-width: 120px; overflow: hidden; text-overflow: ellipsis; font-family: 'Segoe UI', 'Arial', 'sans-serif'; font-weight: 700;">
            KPI
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    @can('dashboard-view')
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt mr-2"></i>
            <span>My Dashboard</span>
        </a>
    </li>
    @endcan

    @hasanyrole('admin|direksi')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Kelola Karyawan
    </div>
    <li class="nav-item {{ request()->is('user*') ? 'active' : '' }}">
        <a class="nav-link" href="/user">
            <i class="fas fa-fw fa-user mr-2"></i>
            <span>Data Karyawan</span>
        </a>
    </li>
    @endhasanyrole

    @role('admin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Kelola KPI
    </div>
    @endrole

    @role('karyawan')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Perhitungan KPI
    </div>
    @endrole
    
    @hasanyrole('admin|karyawan')
    <li class="nav-item {{ request()->is('kpimetrics*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kpimetrics.index') }}">
            <i class="fas fa-fw fa-key mr-2"></i>
            <span>Data KPI</span>
        </a>
    </li>
    @endhasanyrole

    @role('karyawan')
    <li class="nav-item {{ request()->is('hitungkpi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('hitungkpi.index') }}">
            <i class="fas fa-fw fa-calculator mr-2"></i>
            <span>Hitung KPI</span>
        </a>
    </li>
    @endrole

    @role('admin')
    <li class="nav-item {{ request()->is('kpirecords*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kpirecords.index') }}">
            <i class="fas fa-fw fa-calculator mr-2"></i>
            <span>KPI Record</span>
        </a>
    </li>
    @endrole

    @role('admin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Kelola Bantuan
    </div>
    <li class="nav-item {{ request()->is('panduan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('faq.index') }}">
            <i class="fas fa-book-open mr-2"></i>
            <span>Panduan & Kontak Kami</span>
        </a>
    </li>
    @endrole

    
    @role('karyawan')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        <i class=""></i> Reports
    </div>
    <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-clipboard-list mr-2"></i>
            <span>Laporan</span>
        </a>
    </li>
    @endrole
    
    @hasanyrole('admin|direksi')
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Reports
    </div>
    <li class="nav-item {{ request()->is('laporan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan.admin') }}">
            <i class="fas fas fa-file-alt mr-2"></i>
            <span>Resume KPI</span>
        </a>
    </li>
    @endhasanyrole
    
    @role('karyawan')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        <i class=""></i> Pusat Bantuan
    </div>
    <li class="nav-item {{ request()->is('panduan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('faq.index') }}">
            <i class="fas fa-fw fa-book-open mr-2"></i>
            <span>Panduan & Kontak Kami</span>
        </a>
    </li>
    @endrole

    @role('admin')
    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        KELOLA JABATAN
    </div>
    <li class="nav-item {{ request()->is('jobpositions*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('jobpositions.index') }}">
            <i class="fas fa-users-cog mr-2"></i>
            <span>Jabatan</span>
        </a>
    </li>
    @endrole

    <!-- Footer Sidebar -->
    <div class="sidebar-footer text-center mt-auto p-3"
        style="font-size: 0.75rem; color: rgba(255,255,255,0.7); border-top: 1px solid rgba(255,255,255,0.2);">
        <span>&copy; {{ date('Y') }} KPI Calculating PT BABN</span><br>
        <span style="font-size: 0.7rem;">v1.0.0</span>
    </div>
</ul>
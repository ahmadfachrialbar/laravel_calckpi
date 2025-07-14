@extends('layouts.app')

@section('content')

<div class="dashboard-bg">
    <div class="container dashboard-content py-5">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row align-items-start justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-2 text-white font-weight-bold">
                    Welcome, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-white mb-0">Berikut adalah ringkasan aktivitas dan informasi terupdate Anda.</p>
            </div>
            <a href="#" class="btn btn-sm btn-secondary shadow-sm mt-3 mt-md-0">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>

        {{-- Statistik Card --}}
        <div class="row">
            @role('admin')
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Karyawan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKaryawan }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total KPI Metrics</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKpi }}</div>
                    </div>
                </div>
            </div>
            @endrole

            @role('karyawan')
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">KPI Anda</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUserKpi }}</div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Score KPI Anda</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">-</div>
                    </div>
                </div>
            </div>
            @endrole
        </div>

        {{-- Konten Tambahan --}}
        <div class="row">
            {{-- Aktivitas Terakhir --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-primary text-white font-weight-bold">Aktivitas Terakhir</div>
                    <div class="card-body small">
                        <ul class="list-unstyled mb-0">
                            @role('karyawan')
                            <li>✅ Melihat Data KPI</li>
                            <li>✅ Melihat Panduan</li>
                            <li>📊 Melihat Riwayat perhitungan</li>
                            <li>📄 Mengupdate Data karyawan</li>
                            <li>📊 Kelola Data Karyawan</li>
                            @endrole
                            @role('admin')
                            <li>📊 Menhitung KPI</li>
                            <li>🔎 Melihat hasil perhitungan</li>
                            <li>📄 Melihat Profile</li>
                            @endrole
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Panduan Singkat --}}
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-success text-white font-weight-bold">Panduan Singkat</div>
                    <div class="card-body">
                        <p class="small mb-2">Bingung cara menggunakan fitur? Baca panduan lengkap mengenai perhitungan KPI dan penggunaan sistem.</p>
                        <a href="{{ route('faq.index') }}" class="btn btn-outline-success btn-sm">Buka Panduan</a>
                    </div>
                </div>
            </div>

            {{-- Navigasi Cepat --}}
            <div class="col-xl-4 col-md-12 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header bg-info text-white font-weight-bold">Navigasi Cepat</div>
                    <div class="card-body small">
                        @role('admin')
                        <a href="{{ route('user.index') }}" class="d-block mb-2 text-decoration-none text-info">
                            <i class="fas fa-users mr-2"></i> Data Karyawan
                        </a>
                        <a href="{{ route('kpimetrics.index') }}" class="d-block mb-2 text-decoration-none text-info">
                            <i class="fas fa-chart-bar mr-2"></i> Data KPI
                        </a>
                        <a href="{{ route('hitungkpi.index') }}" class="d-block text-decoration-none text-info">
                            <i class="fas fa-calculator mr-2"></i> Hitung KPI
                        </a>
                        @endrole
                        @role('karyawan')
                        <a href="{{ route('kpimetrics.index') }}" class="d-block mb-2 text-decoration-none text-info">
                            <i class="fas fa-chart-bar mr-2"></i> Data KPI
                        </a>
                        <a href="{{ route('hitungkpi.index') }}" class="d-block text-decoration-none text-info">
                            <i class="fas fa-calculator mr-2"></i> Hitung KPI
                        </a>
                        <a href="{{ route('profile.index') }}" class="d-block text-decoration-none text-info">
                            <i class="fas fa-user mr-2"></i> Profile Saya
                        </a>   
                        <a href="{{ route('faq.index') }}" class="d-block text-decoration-none text-info">
                            <i class="fas fa-book-open mr-2"></i> Panduan
                        </a>
                        @endrole
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

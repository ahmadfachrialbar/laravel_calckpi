@extends('layouts.app')

@section('content')

<div class="dashboard-bg">
    <div class="container dashboard-content py-6">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row align-items-start justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-2 text-white font-weight-bold">
                    Welcome, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-white mb-0">Selamat datang di Website Calculating KPI Karyawan PT Anugrah Beton Nusantara</p>
            </div>
            <a href="{{ route('laporan.admin.download') }}" class="btn btn-sm btn-secondary shadow-sm mt-3 mt-md-0">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>

        {{-- Statistik Card --}}
        @role('admin')
        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Karyawan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKaryawan ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endrole

        @role('karyawan')
        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total KPI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKpi ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endrole

    </div>
</div>
@endsection
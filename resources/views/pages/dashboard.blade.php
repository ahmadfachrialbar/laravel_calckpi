@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-flex flex-column flex-md-row align-items-start justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-2 text-gray-700 font-weight-bold">
            Welcome, {{ Auth::user()->name }} 👋
        </h1>
        <p class="text-muted mb-0">Berikut adalah ringkasan aktivitas dan informasi terupdate Anda.</p>
    </div>
    <a href="#" class="btn btn-sm btn-secondary shadow-sm mt-3 mt-md-0">
        <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
    </a>
</div>

<div class="row">
    @role('admin')
    <!-- Total Karyawan -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Karyawan</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKaryawan }}</div>
            </div>
        </div>
    </div>

    <!-- Total KPI -->
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
    <!-- KPI Saya -->
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
                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
            </div>
        </div>
    </div>
    @endrole
</div>

@endsection
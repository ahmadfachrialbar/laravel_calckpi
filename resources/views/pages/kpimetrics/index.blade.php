@extends('layouts.app')
@section('content')

@role('admin')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data KPI</h1>
    <a href="{{route('kpimetrics.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Jabatan</th>
                <th>Nama KPI</th>
                <th>Cara Ukur</th>
                <th>Target</th>
                <th>Bobot</th>

                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($karyawan as $user)
            @php
            $jobKpis = $user->jobPosition->kpiMetrics ?? collect();
            $userKpis = $user->kpiMetrics ?? collect();
            $allKpis = $jobKpis->map(function ($kpi) {
            $kpi->source = 'Jabatan';
            return $kpi;
            })->merge(
            $userKpis->map(function ($kpi) {
            $kpi->source = 'Khusus User';
            return $kpi;
            })
            );
            @endphp

            @if ($allKpis->count())
            @foreach ($allKpis as $kpi)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->jobPosition->name ?? '-' }}</td>
                <td>{{ $kpi->nama_kpi }}</td>
                <td>{{ $kpi->cara_ukur }}</td>
                <td>{{ $kpi->target }}</td>
                <td>{{ $kpi->bobot }}</td>

                <td>
                    <a href="{{ route('kpimetrics.edit', $kpi->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('kpimetrics.destroy', $kpi->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus KPI ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->jobPosition->name ?? '-' }}</td>
                <td colspan="6" class="text-center"><em>Tidak ada KPI</em></td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@endrole

@role('karyawan')
<h4>KPI Posisi: {{ auth()->user()->jobPosition->name ?? '-' }}</h4>
<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>Nama KPI</th>
            <th>Cara Ukur</th>
            <th>Target</th>
            <th>Bobot</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($kpiMetrics as $kpi)
        <tr>
            <td>{{ $kpi->nama_kpi }}</td>
            <td>{{ $kpi->cara_ukur }}</td>
            <td>{{ $kpi->target }}</td>
            <td>{{ $kpi->bobot }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4"><i>Belum ada KPI</i></td>
        </tr>
        @endforelse
    </tbody>
</table>
@endrole

@endsection
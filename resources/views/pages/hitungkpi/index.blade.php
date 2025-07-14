@extends('layouts.app')
@section('content')
<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Hitung KPI</h1>
    <hr class="sidebar-divider">

    <div class="row mb-4">
        <div class="col-md-8">
            <p class="text-muted mb-0">
                Nama :  {{ auth()->user()->name }} ({{ auth()->user()->nip }})
            </p>
            <p class="text-muted mb-0">
                Jabatan/Departemen :  {{ auth()->user()->jobPosition->name ?? '-' }}
            </p>
        </div>
        <div class="col-md-4 text-md-end text-right mt-3 mt-md-0">
            <form method="POST" action="{{ route('hitungkpi.store') }}">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    Hitung
                </button>
            </form>
        </div>
    </div>


    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->hasRole('karyawan'))
    <form action="{{ route('hitungkpi.store') }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama KPI</th>
                        <th>Penjelasan</th>
                        <th>Target</th>
                        <th>Bobot</th>
                        <th>Weightages</th>
                        <th>Simulasi Penambahan</th>
                        <th>Achievement</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kpis as $index => $kpi)
                    @php
                    $record = $records->firstWhere('kpimetrics_id', $kpi->id);
                    $simulasi = old("kpi.$index.simulasi_penambahan");
                    $achievement = $simulasi ? number_format(($simulasi / $kpi->target), 2) : '-';
                    $score = $simulasi ? number_format(($simulasi / $kpi->target) * $kpi->weightages, 2) : '-';
                    @endphp
                    <tr class="text-center align-middle">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kpi->nama_kpi }}</td>
                        <td>{{ $kpi->penjelasan_sederhana }}</td>
                        <td>{{ $kpi->target }}</td>
                        <td>{{ $kpi->bobot }}</td>
                        <td>{{ $kpi->weightages }}</td>
                        <td>
                            <input type="hidden" name="kpi[{{ $index }}][metric_id]" value="{{ $kpi->id }}">
                            <input type="number" name="kpi[{{ $index }}][simulasi_penambahan]" class="form-control text-center" step="0.01" value="{{ $simulasi }}">
                        </td>
                        <td>{{ $achievement }}</td>
                        <td>{{ $score }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </form>

    <hr>
    <h4>Riwayat Perhitungan Anda</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-light">
                <tr>
                    <th>Nama KPI</th>
                    <th>Simulasi</th>
                    <th>Achievement</th>
                    <th>Weightages</th>
                    <th>Score</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->kpiMetric->nama_kpi }}</td>
                    <td>{{ $record->simulasi_penambahan }}</td>
                    <td>{{ $record->achievement }}</td>
                    <td>{{ $record->kpiMetric->weightages }}</td>
                    <td>{{ $record->score }}</td>
                    <td>{{ $record->created_at?->format('d-m-Y H:i') ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6"><em>Belum ada riwayat</em></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif

    @role('admin')
    <h4>Riwayat Perhitungan Semua Karyawan</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-light">
                <tr>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>Nama KPI</th>
                    <th>Simulasi</th>
                    <th>Achievement</th>
                    <th>Weightages</th>
                    <th>Score</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                <tr>
                    <td>{{ $record->user->name }}</td>
                    <td>{{ $record->user->jobPosition->name ?? '-' }}</td>
                    <td>{{ $record->kpiMetric->nama_kpi }}</td>
                    <td>{{ $record->simulasi_penambahan }}</td>
                    <td>{{ $record->achievement }}</td>
                    <td>{{ $record->weightages }}</td>
                    <td>{{ $record->score }}</td>
                    <td>{{ $record->created_at?->format('d-m-Y H:i') ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8"><em>Belum ada riwayat</em></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endrole
</div>
@endsection
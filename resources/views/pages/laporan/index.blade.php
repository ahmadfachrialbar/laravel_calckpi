@extends('layouts.app')
@section('content')

<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Laporan Hasil Perhitungan KPI</h1>
    <hr class="sidebar-divider">
    <p class="text-muted">
        Nama: {{ $user->name }} ({{ $user->nip }}) <br>
        Jabatan: {{ $user->jobPosition->name ?? '-' }}
    </p>

    @if($records->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Nama KPI</th>
                    <th>Deskripsi</th>
                    <th>Cara Ukur</th>
                    <th>Target</th>
                    <th>Bobot</th>
                    <th>Simulasi Penambahan</th>
                    <th>Achievement</th>
                    <th>Weightages</th>
                    <th>Score</th>
                    <th>Waktu Perhitungan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->kpiMetric->nama_kpi }}</td>
                    <td>{{ $record->kpiMetric->penjelasan_sederhana }}</td>
                    <td>{{ $record->kpiMetric->cara_ukur }}</td>
                    <td>{{ $record->kpiMetric->target }}%</td>
                    <td>{{ $record->kpiMetric->bobot }}%</td>
                    <td>{{ $record->simulasi_penambahan }}%</td>
                    <td>{{ $record->achievement }}%</td>
                    <td>{{ $record->kpiMetric->weightages }}%</td>
                    <td>{{ $record->score }}%</td>
                    <td>{{ $record->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">
        Belum ada riwayat perhitungan KPI.
    </div>
    @endif

    <a href="{{ route('hitungkpi.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    @role('karyawan')
    <a href="{{ route('laporan.download') }}" class="btn btn-success fas fa-file-excel mt-3"> Download Excel</a>

    @endrole

</div>

@endsection
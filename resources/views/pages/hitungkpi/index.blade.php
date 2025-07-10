@extends('layouts.app')
@section('content')

<h3>Data KPI untuk: {{ $user->name }}</h3>

<form action="{{ route('hitungkpi.store') }}" method="POST">
    @csrf

    @foreach($kpis as $index => $kpi)
    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $kpi->nama_kpi }}</h5>
            <p>{{ $kpi->penjelasan_sederhana }}</p>

            <input type="hidden" name="kpi[{{ $index }}][metric_id]" value="{{ $kpi->id }}">
            <div class="form-group">
                <label>Simulasi Tambahan (angka)</label>
                <input type="number" class="form-control" name="kpi[{{ $index }}][realization]" required>
            </div>
        </div>
    </div>
    @endforeach

    <button class="btn btn-primary" type="submit">Hitung KPI</button>
</form>

@if(session('success'))
<div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

@if($records->count())
<h4 class="mt-5">Hasil Perhitungan</h4>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Nama KPI</th>
            <th>Realisasi</th>
            <th>Target</th>
            <th>Bobot</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        @foreach($records as $record)
        <tr>
            <td>{{ $record->kpiMetric->nama_kpi }}</td>
            <td>{{ $record->realization }}</td>
            <td>{{ $record->kpiMetric->target }}</td>
            <td>{{ $record->kpiMetric->bobot }}</td>
            <td>{{ $record->score }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@endsection

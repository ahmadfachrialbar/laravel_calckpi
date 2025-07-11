@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Hitung KPI</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($kpis->isEmpty())
        <div class="alert alert-warning">Belum ada KPI untuk jabatan Anda.</div>
    @else
        <form action="{{ route('hitungkpi.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <strong>Nama:</strong> {{ $user->name }} <br>
                <strong>Jabatan:</strong> {{ $user->jobPosition->name ?? '-' }}
            </div>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama KPI</th>
                        <th>Target</th>
                        <th>Bobot</th>
                        <th>Realisasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kpis as $index => $kpi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $kpi->nama_kpi }}
                                <input type="hidden" name="kpi[{{ $index }}][metric_id]" value="{{ $kpi->id }}">
                            </td>
                            <td>{{ $kpi->target }}</td>
                            <td>{{ $kpi->bobot }}</td>
                            <td>
                                <input type="number" name="kpi[{{ $index }}][realization]" step="0.01" class="form-control" required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Simpan Perhitungan</button>
        </form>
    @endif

    @if(!$records->isEmpty())
        <hr>
        <h4 class="mt-4">Riwayat Perhitungan KPI</h4>
        <table class="table table-striped">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama KPI</th>
                    <th>Realisasi</th>
                    <th>Score</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $record->kpiMetric->nama_kpi ?? '-' }}</td>
                        <td>{{ $record->realization }}</td>
                        <td>{{ $record->score }}</td>
                        <td>{{ $record->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

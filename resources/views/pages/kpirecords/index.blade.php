@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-3 text-gray-700 font-weight-bold">Riwayat Perhitungan KPI Karyawan</h1>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Riwayat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Nama KPI</th>
                            <th>Target</th>
                            <th>Simulasi</th>
                            <th>Achievement</th>
                            <th>Weightages</th>
                            <th>Score</th>
                            <th>Waktu</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $index => $record)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $record->user->name }}</td>
                            <td>{{ $record->user->jobPosition->name ?? '-' }}</td>
                            <td>{{ $record->kpiMetric->nama_kpi }}</td>
                            <td>{{ $record->kpiMetric->target }}</td>
                            <td>{{ $record->simulasi_penambahan }}</td>
                            <td>{{ $record->achievement }}</td>
                            <td>{{ $record->kpiMetric->weightages }}</td>
                            <td>{{ $record->score }}</td>
                            <td>{{ $record->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="{{ route('kpirecords.edit', $record->id) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <!-- Tombol Hapus -->
                                <form action="{{ route('kpirecords.destroy', $record->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus KPI ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center"><em>Tidak ada data</em></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
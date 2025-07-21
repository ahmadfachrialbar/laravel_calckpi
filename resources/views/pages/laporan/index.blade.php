@extends('layouts.app')
@section('content')

@role('karyawan')
<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Laporan Hasil Perhitungan KPI</h1>
    <hr class="sidebar-divider">

    <div class="card p-3 mb-3 shadow-sm border-0">
        <div class="d-flex align-items-center mb-1">
            <span class="text-muted font-weight-bold mr-2" style="min-width: 120px;">NIP</span>
            <span class="text-dark">: {{ auth()->user()->nip }}</span>
        </div>
        <div class="d-flex align-items-center mb-1">
            <span class="text-muted font-weight-bold mr-2" style="min-width: 120px;">Nama</span>
            <span class="text-dark">: {{ auth()->user()->name }}</span>
        </div>
        <div class="d-flex align-items-center">
            <span class="text-muted font-weight-bold mr-2" style="min-width: 120px;">Jabatan/Dept</span>
            <span class="text-dark">: {{ auth()->user()->jobPosition->name ?? '-' }}</span>
        </div>
    </div>

    @if($records->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center" id="table-karyawan">
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

    @php
    $totalScore = $records->groupBy('kpimetrics_id')
    ->map(fn($items) => $items->sortByDesc('created_at')->first())
    ->sum('score');
    @endphp

    <div class="alert alert-info mt-3 text-right">
        <strong>Total Score Anda:</strong> {{ number_format($totalScore, 2) }}%
    </div>
    @else
    <div class="alert alert-info">
        Belum ada riwayat perhitungan KPI.
    </div>
    @endif

    <a href="{{ route('hitungkpi.index') }}" class="btn btn-secondary mt-1 mb-4">Kembali</a>
    <a href="{{ route('laporan.download') }}" class="btn btn-success mt-1 mb-4">
        <i class="fas fa-file-excel"></i> Download Excel
    </a>
</div>
@endrole

@role('admin')
<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Laporan KPI Seluruh Karyawan</h1>
    <hr class="sidebar-divider">

    @if($karyawan->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center" id="table-admin">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan/Dept</th>
                    <th>Total Score</th>
                    <th>Indikator</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawan as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->nip }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->job }}</td>
                    <td>{{ number_format($data->total_score, 2) }}%</td>
                    <td>
                        <span class="badge badge-{{ $data->indikator == 'Baik' ? 'success' : ($data->indikator == 'Cukup' ? 'warning' : 'danger') }}">
                            {{ $data->indikator }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-center" style="gap: 0.5rem;">
                            <a href="{{ route('laporan.admin.show', $data->id) }}" class="btn btn-link p-0 text-info" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">Belum ada data KPI.</div>
    @endif

    <a href="{{ route('laporan.admin.download') }}" class="btn btn-success mt-3">
        <i class="fas fa-file-excel"></i> Download Excel
    </a>
</div>
@endrole
@endsection

@section('scripts')
{{-- ✅ Tambahkan DataTables --}}
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Untuk tabel karyawan
        if ($('#table-karyawan').length) {
            $('#table-karyawan').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                autoWidth: false,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" // Bahasa Indonesia
                }
            });
        }

        // Untuk tabel admin
        if ($('#table-admin').length) {
            $('#table-admin').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                autoWidth: false,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                }
            });
        }
    });
</script>
@endsection
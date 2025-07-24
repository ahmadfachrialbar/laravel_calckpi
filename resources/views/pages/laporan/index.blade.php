@extends('layouts.app')
@section('content')

@role('karyawan')

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
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center" id="dataTableFull">
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
            <div class="alert alert-info mt-3 text-right">
                <strong>Total Score Anda:</strong> {{ number_format($totalScore, 2) }}%
            </div>
            @else
            <div class="alert alert-info">Belum ada riwayat perhitungan KPI.</div>
            @endif
        
            <a href="{{ route('hitungkpi.index') }}" class="btn btn-secondary mt-1">Kembali</a>
            <a href="{{ route('laporan.download') }}" class="btn btn-success mt-1">
                <i class="fas fa-file-excel"></i> Download Excel
            </a>
        </div>
    </div>
@endrole

{{-- Admin juga bisa melihat laporan di index.blade, jika mau --}}
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function(){
        $('#dataTableFull').DataTable({
            scrollX: true,
            language: {
                search : "Cari Data :"
            }
        });
    });
</script>
@endpush
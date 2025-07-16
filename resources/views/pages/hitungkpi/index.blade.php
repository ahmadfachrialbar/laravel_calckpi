@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Hitung KPI</h1>
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

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->hasRole('karyawan'))
    <form action="{{ route('hitungkpi.store') }}" method="POST" id="form-kpi">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama KPI</th>
                        <th>Deskripsi</th>
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
                    $record = $records[$kpi->id] ?? null;
                    $simulasi = $record->simulasi_penambahan ?? old("kpi.$index.simulasi_penambahan");
                    @endphp
                    <tr class="text-center align-middle">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kpi->nama_kpi }}</td>
                        <td>{{ $kpi->penjelasan_sederhana }}</td>
                        <td class="target">{{ $kpi->target }}%</td>
                        <td class="bobot">{{ $kpi->bobot }}%</td>
                        <td class="weightages">{{ $kpi->weightages }}%</td>
                        <td>
                            <input type="hidden" name="kpi[{{ $index }}][metric_id]" value="{{ $kpi->id }}">
                            <input type="number"
                                name="kpi[{{ $index }}][simulasi_penambahan]"
                                class="form-control text-center simulasi"
                                step="0.01"
                                value="{{ $simulasi }}">
                        </td>
                        <td class="achievement">-</td>
                        <td class="score">-</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-secondary mt-3">Simpan & Hitung</button>
    </form>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function hitungKPI(row) {
            const simulasi = parseFloat(row.querySelector('.simulasi').value) || 0;
            const target = parseFloat(row.querySelector('.target').textContent) || 1;
            const bobot = parseFloat(row.querySelector('.bobot').textContent) || 0;
            const weightages = parseFloat(row.querySelector('.weightages').textContent) || 0;

            // Rumus sesuai Excel
            const achievement = ((simulasi + bobot) / target) * 100;
            const score = (achievement * weightages) / 100;

            row.querySelector('.achievement').textContent = achievement.toFixed(2) + '%';
            row.querySelector('.score').textContent = score.toFixed(2) + '%';
        }

        document.querySelectorAll('.simulasi').forEach(input => {
            const row = input.closest('tr');

            // Hitung otomatis saat halaman pertama kali load
            hitungKPI(row);

            // Hitung otomatis saat user mengetik
            input.addEventListener('input', function() {
                hitungKPI(row);
            });
        });
    });
</script>
@endsection
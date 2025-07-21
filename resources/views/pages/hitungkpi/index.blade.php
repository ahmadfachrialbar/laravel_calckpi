@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Hitung KPI</h1>
    <hr class="sidebar-divider">
</div>

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
                    <th>Kategori</th>
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
                    <td class="target">{{ $kpi->target }}</td>
                    <td class="bobot">{{ $kpi->bobot }}</td>
                    <td class="weightages">{{ $kpi->weightages }}</td>
                    <td class="kategori">{{ $kpi->kategori }}</td>
                    <td>
                        <input type="hidden" name="kpi[{{ $index }}][metric_id]" value="{{ $kpi->id }}">
                        <input type="number"
                            name="kpi[{{ $index }}][simulasi_penambahan]"
                            class="form-control text-center simulasi"
                            step="0.01"
                            value="{{ $simulasi }}">
                    </td>
                    <td class="achievement">{{ $record->achievement ?? '-' }}</td>
                    <td class="score">{{ $record->score ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3">
            <div class="alert alert-info text-right">
                <strong>Total Score Anda:</strong>
                <span id="total-score">{{ number_format($totalScore, 2) }}</span>%
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-secondary mt-3 mb-4">Simpan & Hitung</button>
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
            const kategori = row.querySelector('.kategori').textContent.trim().toLowerCase();

            let achievement = 0;

            switch (kategori) {
                case 'up': 
                    achievement = ((bobot + simulasi) / target) * 100;
                    if (achievement > 100) achievement = 100;
                    break;

                case 'down': 
                    achievement = (target / (bobot + simulasi)) * 100;
                    if (achievement > 100) achievement = 100;
                    break;

                case 'zero': 
                    achievement = (((bobot + simulasi) / 4)) * 100;
                    break;

                default:
                    achievement = 0;
            }


            const score = (achievement * weightages) / 100;

            row.querySelector('.achievement').textContent = achievement.toFixed(2);
            row.querySelector('.score').textContent = score.toFixed(2);

            return score;
        }

        function updateTotalScore() {
            let total = 0;
            document.querySelectorAll('tbody tr').forEach(row => {
                total += parseFloat(row.querySelector('.score').textContent) || 0;
            });
            document.getElementById('total-score').textContent = total.toFixed(2);
        }

        document.querySelectorAll('.simulasi').forEach(input => {
            const row = input.closest('tr');
            hitungKPI(row);
            input.addEventListener('input', function() {
                hitungKPI(row);
                updateTotalScore();
            });
        });

        updateTotalScore();
    });
</script>
@endsection
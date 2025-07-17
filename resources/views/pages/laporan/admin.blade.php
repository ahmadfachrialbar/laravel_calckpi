@extends('layouts.app')
@section('content')

<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Laporan KPI Seluruh Karyawan</h1>
    <hr class="sidebar-divider">

    @if($karyawan->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan/Dept</th>
                    <th>Total Score</th>
                    <th>Indikator</th>
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
                        @php
                        $badgeClass = match($data->indikator) {
                            'Baik' => 'success',
                            'Belum hitung' => 'success',
                            'Cukup' => 'warning',
                            default => 'danger',
                        };
                        @endphp
                        <span class="badge badge-{{ $badgeClass }}">
                            {{ $data->indikator }}
                        </span>
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
@endsection
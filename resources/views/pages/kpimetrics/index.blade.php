@extends('layouts.app')

@section('content')

@role('admin')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Data KPI</h1>
    <a href="{{ route('kpimetrics.create') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
    </a>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data KPI</h6>
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
                        <th>Deskripsi</th>
                        <th>Parameter</th>
                        <th>Target</th>
                        <th>Actual</th>
                        <th>Weightages</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp

                    {{-- KPI berdasarkan karyawan dan jabatannya --}}

                    @foreach ($karyawan as $user)
                    @php
                    $jobKpis = $user->jobPosition->kpiMetrics ?? collect();
                    $userKpis = $user->kpiMetrics ?? collect();
                    $allKpis = $jobKpis->map(function ($kpi) {
                    $kpi->source = 'Jabatan';
                    return $kpi;
                    })->merge(
                    $userKpis->map(function ($kpi) {
                    $kpi->source = 'User';
                    return $kpi;
                    })
                    );
                    @endphp

                    @if ($allKpis->count())
                    @foreach ($allKpis as $kpi)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->jobPosition->name ?? '-' }}</td>
                        <td>{{ $kpi->nama_kpi }}</td>
                        <td>{{ $kpi->penjelasan_sederhana }}</td>
                        <td>{{ $kpi->cara_ukur }}</td>
                        <td>{{ $kpi->target }}%</td>
                        <td>{{ $kpi->bobot }}%</td>
                        <td>{{ $kpi->weightages }}%</td>

                        <td>
                            <div class="d-flex justify-content-center" style="gap: 0.5rem;">
                                <!-- Tombol Lihat -->
                                <a href="{{ route('kpimetrics.show', $kpi->id) }}" class="btn btn-link p-0 text-info" title="Lihat KPI">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- Tombol Edit -->
                                <a href="{{ route('kpimetrics.edit', $kpi->id) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('kpimetrics.destroy', $kpi->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus KPI ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @endforeach
                    @endif
                    @endforeach

                    {{-- KPI yang tidak punya relasi --}}
                    @if(isset($kpiOrphan) && $kpiOrphan->count())
                    @foreach ($kpiOrphan as $kpi)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td><em>Tidak diketahui</em></td>
                        <td><em>Tidak diketahui</em></td>
                        <td>{{ $kpi->nama_kpi }}</td>
                        <td>{{ $kpi->penjelasan_sederhana }}</td>
                        <td>{{ $kpi->cara_ukur }}</td>
                        <td>{{ $kpi->target }}</td>
                        <td>{{ $kpi->bobot }}</td>
                        <td>
                            <a href="{{ route('kpimetrics.edit', $kpi->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('kpimetrics.destroy', $kpi->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus KPI ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endrole

@role('karyawan')
<h1 class="h3 mb-2 text-gray-700 font-weight-bold">Data KPI</h1>
<hr class="sidebar-divider">

<p class="text-muted mb-0">Nama : {{ auth()->user()->name }} ({{ auth()->user()->nip }})</p>
<p class="text-muted mb-3">Jabatan/Departemen : {{ auth()->user()->jobPosition->name ?? '-' }}</p>

<div class="card shadow mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data KPI</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Nama KPI</th>
                            <th>Deskripsi</th>
                            <th>Parameter</th>
                            <th>Target</th>
                            <th>Actual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kpiMetrics as $kpi)
                        <tr>
                            <td>{{ $kpi->nama_kpi }}</td>
                            <td>{{ $kpi->penjelasan_sederhana }}</td>
                            <td>{{ $kpi->cara_ukur }}</td>
                            <td>{{ $kpi->target }}</td>
                            <td>{{ $kpi->bobot }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"><i>Belum ada KPI</i></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endrole

@endsection
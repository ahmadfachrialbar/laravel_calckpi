@extends('layouts.app')

@section('content')
@role('admin')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola Data KPI</h1>
</div>
<hr class="divider">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data KPI per Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- Ubah ID di sini -->
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light text-center">
                    <tr>
                        <th>ID</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan/Departemen</th>
                        <th>Tanggal Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($karyawan as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->nip }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->jobPosition->name ?? '-' }}</td>
                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                        <td class="text-center">
                            <a href="{{ route('kpimetrics.create', ['user_id' => $user->id]) }}" class="btn btn-sm text-success" title="Tambah KPI">
                                <i class="fas fa-plus"></i>
                            </a>

                            <a href="{{ route('kpimetrics.show', $user->id) }}" class="btn btn-sm text-primary" title="Lihat KPI">
                                <i class="fas fa-search-plus"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endrole

{{-- Bagian karyawan --}}
@role('karyawan')
<h1 class="h3 mb-2 text-gray-700 font-weight-bold">Data KPI</h1>
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data KPI</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered feedback-table" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>Nama KPI</th>
                        <th>Deskripsi</th>
                        <th>Parameter</th>
                        <th>Target</th>
                        <th>Actual</th>
                        <th>Kategori</th>
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
                        <td>{{ $kpi->kategori }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center"><i>Belum ada KPI</i></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endrole
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
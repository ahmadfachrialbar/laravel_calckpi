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
        <h6 class="m-0 font-weight-bold">Data KPI</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white" id="dataTableKpiAdmin" width="100%" cellspacing="0">
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
                                    <a href="{{ route('kpimetrics.show', $kpi->id) }}" class="btn btn-link p-0 text-info" title="Lihat">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kpimetrics.edit', $kpi->id) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-link p-0 text-danger btn-delete-kpi"
                                        data-id="{{ $kpi->id }}"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endforeach

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
                            <td>{{ $kpi->weightages }}</td>
                            <td>
                                <a href="{{ route('kpimetrics.edit', $kpi->id) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-link p-0 text-danger btn-delete-kpi"
                                    data-id="{{ $kpi->id }}"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Form delete untuk SweetAlert2 -->
<form id="deleteKpiForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
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
            <table class="table table-bordered" id="dataTableKpiKaryawan" width="100%" cellspacing="0">
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
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (document.querySelector('#dataTableKpiAdmin')) {
            $('#dataTableKpiAdmin').DataTable({
                ordering: true,
                searching: true,
                paging: true,
                info: true,
                language: {
                    search: "Cari Data:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)"
                }
            });
        }

        if (document.querySelector('#dataTableKpiKaryawan')) {
            $('#dataTableKpiKaryawan').DataTable({
                ordering: true,
                searching: true,
                paging: true,
                info: true,
                language: {
                    search: "Cari Data:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)"
                }
            });
        }

        // SweetAlert2 untuk tombol hapus KPI
        document.querySelectorAll('.btn-delete-kpi').forEach(button => {
            button.addEventListener('click', function () {
                const kpiId = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Yakin ingin menghapus KPI?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#6c757d',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: true 
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('deleteKpiForm');
                        form.setAttribute('action', '/kpimetrics/delete/' + kpiId);
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush

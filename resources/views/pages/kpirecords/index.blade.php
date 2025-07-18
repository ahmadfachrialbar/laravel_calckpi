@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Riwayat Perhitungan KPI Karyawan</h1>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Riwayat</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white" id="dataTable" width="100%" cellspacing="0">
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
                        <td>{{ $record->kpiMetric->nama_kpi ?? '-' }}</td>
                        <td>{{ $record->kpiMetric->target ?? '-' }}</td>
                        <td>{{ $record->simulasi_penambahan }}</td>
                        <td>{{ $record->achievement }}</td>
                        <td>{{ $record->kpiMetric->weightages ?? '-' }}</td>
                        <td>{{ $record->score }}</td>
                        <td>{{ $record->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            <a href="{{ route('kpirecords.edit', $record->id) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                class="btn btn-link p-0 text-danger btn-delete"
                                data-id="{{ $record->id }}"
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
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

<!-- Form delete global -->
<form id="deleteRecordForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $('#dataTable').DataTable({
        ordering: true,
        searching: true,
        paging: true,
        info: true,
        responsive: true,
        language: {
            search: "Cari Data:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Tidak ditemukan data yang sesuai",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)"
        },
        order: [[9, "desc"]]
    });

    $('.btn-delete').on('click', function () {
        const recordId = $(this).data('id');
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: true
        }).then((result) => {
            if (result.isConfirmed) {
                const form = $('#deleteRecordForm');
                form.attr('action', '/kpirecords/' + recordId);
                form.submit();
            }
        });
    });
});
</script>
@endpush

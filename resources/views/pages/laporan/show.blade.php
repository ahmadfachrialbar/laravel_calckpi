@extends('layouts.app')
@section('content')

@hasanyrole('admin|direksi')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-gray-700 font-weight-bold">Detail Laporan KPI: {{ $user->name }}</h1>
</div>
<hr class="divider">

<!-- Identitas User -->
<div class="card p-3 mb-3 shadow-sm border-0">
    <div class="d-flex align-items-center mb-1">
        <span class="text-muted font-weight-bold mr-2" style="min-width: 120px;">NIP</span>
        <span class="text-dark">: {{ $user->nip }}</span>
    </div>
    <div class="d-flex align-items-center mb-1">
        <span class="text-muted font-weight-bold mr-2" style="min-width: 120px;">Nama</span>
        <span class="text-dark">: {{ $user->name }}</span>
    </div>
    <div class="d-flex align-items-center">
        <span class="text-muted font-weight-bold mr-2" style="min-width: 120px;">Jabatan/Dept</span>
        <span class="text-dark">: {{ $user->jobPosition->name ?? '-' }}</span>
    </div>
</div>

<!-- Tabel KPI -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data KPI</h6>
    </div>
    <div class="card-body">
        @if($records->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped bg-white " id="dataTableDetail" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th style="min-width: 300px;">Nama KPI</th>
                        <th style="min-width: 200px;">Penjelasan</th>
                        <th>Parameter</th>
                        <th>Kategori</th>
                        <th>Target</th>
                        <th>Actual</th>
                        <th>Simulasi</th>
                        <th>Achievement</th>
                        <th>Weightages</th>
                        <th style="min-width: 100px;">Score</th>
                        <th style="min-width: 155px;">Waktu</th>
                        @role('admin')
                        <th>Aksi</th>
                        @endrole
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($records as $index => $record)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="text-left">{{ $record->kpiMetric->nama_kpi }}</td>
                        <td class="text-left">{{ $record->kpiMetric->penjelasan_sederhana }}</td>
                        <td class="text-left">{{ $record->kpiMetric->cara_ukur }}</td>
                        <td>{{ $record->kpiMetric->kategori }}</td>
                        <td>{{ $record->kpiMetric->target }}%</td>
                        <td>{{ $record->kpiMetric->bobot }}%</td>
                        <td>{{ $record->simulasi_penambahan }}%</td>
                        <td>{{ $record->achievement }}%</td>
                        <td>{{ $record->kpiMetric->weightages }}%</td>
                        <td>{{ $record->score }}%</td>
                        <td>{{ $record->created_at->format('d-m-Y H:i') }}</td>
                        @role('admin')
                        <td>
                            <button type="button"
                                class="btn btn-link p-0 text-danger btn-delete"
                                data-id="{{ $record->id }}"
                                title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="alert alert-info mt-3 text-right">
            <strong>Total Score:</strong> {{ number_format($totalScore, 2) }}%
        </div>
        @else
        <div class="alert alert-info">Belum ada riwayat KPI untuk karyawan ini.</div>
        @endif
        <a href="{{ route('laporan.admin') }}" class="btn btn-secondary ">Kembali</a>
        <a href="{{ route('laporan.admin.download.detail', $user->id) }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Download Excel
        </a>

    </div>
</div>

<!-- Form delete global -->
<form id="deleteRecordForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endhasanyrole
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
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
            order: [
                [9, "desc"]
            ]
        });

        $('.btn-delete').on('click', function() {
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
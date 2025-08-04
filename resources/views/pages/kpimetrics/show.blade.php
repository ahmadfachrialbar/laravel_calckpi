@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 text-gray-700 font-weight-bold">Kelola Detail KPI</h1>
</div>
<hr>

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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">Daftar KPI</h6>
            <a href="{{ route('kpimetrics.create', ['user_id' => $user->id]) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" title="Tambah KPI">
                <i class="fas fa-plus fa-sm text-white-50"></i> Tambah KPI
            </a>
        </div>
    </div>
    <div class="card-body">
        @if($kpiMetrics->isEmpty())
            <div class="text-center text-muted">Belum ada data KPI yang diinputkan.</div>
        @else
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTableFull" width="100%" cellspacing="0">
                <thead class="thead-light text-center">
                    <tr>
                        <th>No</th>
                        <th style="min-width: 180px;">Nama KPI</th>
                        <th style="min-width: 220px;">Deskripsi</th>
                        <th style="min-width: 200px;">Cara Ukur</th>
                        <th>Kategori</th>
                        <th>Target</th>
                        <th>Actual</th>
                        <th>Weightages</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kpiMetrics as $index => $kpi)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td style="text-align: justify;">{{ $kpi->nama_kpi }}</td>
                        <td style="text-align: justify;">{{ $kpi->penjelasan_sederhana }}</td>
                        <td style="text-align: justify;">{{ $kpi->cara_ukur }}</td>
                        <td class="text-center">{{ ucfirst($kpi->kategori) }}</td>
                        <td class="text-center">{{ $kpi->target }}%</td>
                        <td class="text-center">{{ $kpi->bobot }}%</td>
                        <td class="text-center">{{ $kpi->weightages }}%</td>
                        <td class="text-center">
                            <a href="{{ route('kpimetrics.edit', $kpi->id) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-link p-0 text-danger btn-delete" data-id="{{ $kpi->id }}" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        <a href="{{ route('kpimetrics.index') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>

<!-- Form delete untuk SweetAlert -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#dataTableFull').DataTable({
            scrollX: true,
            language: {
                search: "Cari Data :"
            }
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
                    const form = $('#deleteForm');
                    form.attr('action', '/kpimetrics/delete/' + recordId);
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

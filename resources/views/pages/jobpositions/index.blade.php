@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Data Jabatan / Departemen</h1>
    <a href="{{ route('jobpositions.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jabatan
    </a>
</div>
<hr class="divider">

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Daftar Jabatan / Departemen</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Jabatan / Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($positions as $position)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $position->name }}</td>
                        <td>
                            <div class="d-flex justify-content-center" style="gap: 0.5rem;">
                                <a href="{{ route('jobpositions.edit', $position->id) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-link p-0 text-danger btn-delete"
                                    data-id="{{ $position->id }}"
                                    data-name="{{ $position->name }}"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Form delete untuk SweetAlert -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<!-- datatables -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    const deleteForm = document.getElementById('deleteForm');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: Jabatan "${name}" akan dihapus permanen.,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: true
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.setAttribute('action', /jobpositions/${id});
                    deleteForm.submit();
                }
            });
        });
    });
});
</script>
@endpush
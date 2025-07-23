@extends('layouts.app')

@section('content')
@hasanyrole('admin|direksi')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola Data Karyawan</h1>
    <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
    </a>
</div>
<hr class="divider">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan/Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user->nip }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->jobPosition->name ?? '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-center" style="gap: 0.5rem;">
                                <a href="{{ route('user.show', ['id' => $user->id]) }}" class="btn btn-link p-0 text-info" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @role('admin')
                                <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button"
                                    class="btn btn-link p-0 text-danger btn-delete"
                                    data-id="{{ $user->id }}"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endrole
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
@endhasanyrole
@endsection

@push('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- File JS eksternal -->
<script src="{{ asset('template/js/delete-confirmation.js') }}"></script>
@endpush

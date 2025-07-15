@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Data Karyawan</h1>
    <a href="{{route('user.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
</div>
<hr class="divider">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan/Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nip }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->jobPosition->name ?? '-' }}</td>
                        <td>
                            <!-- Aksi -->
                            <div class="d-flex justify-content-center" style="gap: 0.5rem;">
                                <!-- Tombol Lihat -->
                                <a href="{{ route('user.show', ['id' => $user->id]) }}" class="btn btn-link p-0 text-info" title="Lihat KPI">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('user.edit', ['id' => $user->id]) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- End of Main Content -->
@endsection
@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Detail Data Karyawan</h1>
</div>
<hr class="divider">

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Data Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Password</th>
                        <th>Jabatan/Departemen</th>
                        <th>Role</th>
                        <th>Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nip }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ Str::limit($user->password, 10, '...') }}</td>
                        <td>{{ $user->jobPosition->name ?? '-' }}</td>
                        <td>{{ $user->role ?? '-' }}</td>
                        <td>{{ $user->join_date }}</td>
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
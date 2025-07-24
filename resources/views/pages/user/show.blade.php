@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Detail Data Karyawan</h1>
</div>
<hr class="divider">

<!-- Employee Detail Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-primary">
        <h6 class="m-0 font-weight-bold text-white">Detail Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <tbody>
                    <!-- <tr>
                        <th width="25%" class="bg-light">ID Karyawan</th>
                        <td>{{ $user->id }}</td>
                    </tr> -->
                    <tr>
                        <th width="25%" class="bg-light">NIP</th>
                        <td>{{ $user->nip }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Nama Lengkap</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Jabatan</th>
                        <td>{{ $user->jobPosition->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Role</th>
                        <td>{{ ucfirst($user->role) ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tanggal Bergabung</th>
                        <td>{{ \Carbon\Carbon::parse($user->join_date)->format('d F Y') }}</td>
                    </tr>
                    <!-- <tr>
                        <th class="bg-light">Status</th>
                        <td>
                            <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                {{ $user->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                    </tr> -->
                </tbody>
            </table>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
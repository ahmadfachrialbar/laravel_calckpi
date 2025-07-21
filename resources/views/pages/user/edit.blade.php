@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Edit data</h1>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div id="form-kpi-wrapper">
        <div class="form-kpi border rounded p-3 mb-3">
            <div class="form-group">
                <label for="nip">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" value="{{ $user->nip }}" required>
            </div>
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>
            <div>
                <label for="job_position_id">Jabatan</label>
                <select name="job_position_id" class="form-control" required>
                    <option value="">Pilih Jabatan</option>
                    @foreach($jobPositions as $job)
                    <option value="{{ $job->id }}" {{ $user->job_position_id == $job->id ? 'selected' : '' }}>
                        {{ $job->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ $user->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="join_date">Tanggal Bergabung</label>
                <input type="date" class="form-control" id="join_date" name="join_date" value="{{ $user->join_date }}" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-3">Simpan</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary mb-3">Kembali</a>
    </div>
</form>
@endsection
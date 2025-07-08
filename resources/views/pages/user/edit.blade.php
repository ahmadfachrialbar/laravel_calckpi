@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit data</h1>
</div>
<form action="{{ route('user.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
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
    <div class="form-group">
        <label for="jabatan">Jabatan</label>
        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $user->jabatan }}" required>
    </div>
    <div class="form-group">
        <label for="departemen">Departemen</label>
        <input type="text" class="form-control" id="departemen" name="departemen" value="{{ $user->departemen }}" required>
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
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="/user" class="btn btn-secondary" href="">Kembali</button>
</form>
@endsection
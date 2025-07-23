@extends('layouts.app')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola Data Karyawan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Form tambah Data Karyawan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('user.storeMultiple') }}" method="POST">
            @csrf
            <div id="form-user-wrapper">
                <div class="form-user border rounded p-3 mb-3">
                    <div class="form-group">
                        <label>NIP</label>
                        <input type="text" name="users[0][nip]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="users[0][name]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="users[0][email]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" name="users[0][password]" id="password" class="form-control" required>
                            <div class="input-group-append">
                                <span class="input-group-text" style="cursor:pointer;" onclick="togglePassword()">
                                    <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="job_position_id">Jabatan</label>
                        <select name="users[0][job_position_id]" class="form-control">
                            <option value="">Pilih Jabatan</option>
                            @foreach($jobPositions as $job)
                            <option value="{{ $job->id }}">{{ $job->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="users[0][role]" class="form-control" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="karyawan">Karyawan</option>
                            <option value="direksi">Direksi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Bergabung</label>
                        <input type="date" name="users[0][join_date]" class="form-control" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-form">Tambah Form</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<script>
    let index = 1;
    document.getElementById('add-form').addEventListener('click', function () {
        const wrapper = document.getElementById('form-user-wrapper');
        wrapper.insertAdjacentHTML('beforeend', generateFormFields(index));
        index++;
    });

    function generateFormFields(i) {
        return `
        <div class="form-user border rounded p-3 mb-3">
            <div class="form-group">
                <label>NIP</label>
                <input type="text" name="users[${i}][nip]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="users[${i}][name]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="users[${i}][email]" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="users[${i}][password]" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="job_position_id">Jabatan</label>
                <select name="users[${i}][job_position_id]" class="form-control">
                    <option value="">Pilih Jabatan</option>
                    @foreach($jobPositions as $job)
                        <option value="{{ $job->id }}">{{ $job->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="users[${i}][role]" class="form-control" required>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="karyawan">Karyawan</option>
                    <option value="direksi">Direksi</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Bergabung</label>
                <input type="date" name="users[${i}][join_date]" class="form-control" required>
            </div>
        </div>`;
    }

    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const icon = document.getElementById("togglePasswordIcon");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>
@endsection

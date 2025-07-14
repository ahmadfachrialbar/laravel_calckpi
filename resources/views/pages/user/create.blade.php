@extends('layouts.app')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Tambah Data Karyawan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data Karyawan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('user.store') }}" method="POST">
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
                        <input type="password" name="users[0][password]" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="users[0][jabatan]" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Role</label>
                        <select name="users[0][role]" class="form-control" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="karyawan">Karyawan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Bergabung</label>
                        <input type="date" name="users[0][join_date]" class="form-control" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-form">Next</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            
        </form>
    </div>
</div>

<script>
    let index = 1;
    document.getElementById('add-form').addEventListener('click', function() {
        const wrapper = document.getElementById('form-user-wrapper');

        const html = `
        ${generateFormFields(index)}
        </div>`;
        wrapper.insertAdjacentHTML('beforeend', html);
        index++;
    });

    function generateFormFields(i) {
        return `
        <div class="form-group">
            <label for="users[${i}][nip]">NIP</label>
            <input type="text" name="users[${i}][nip]" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="users[${i}][name]">Nama</label>
            <input type="text" name="users[${i}][name]" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="users[${i}][email]">Email</label>
            <input type="email" name="users[${i}][email]" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="users[${i}][password]">Password</label>
            <input type="password" name="users[${i}][password]" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="users[${i}][jabatan]">Jabatan</label>
            <input type="text" name="users[${i}][jabatan]" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="users[${i}][departemen]">Departemen</label>
            <input type="text" name="users[${i}][departemen]" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="users[${i}][role]">Role</label>
            <select name="users[${i}][role]" class="form-control" required>
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="karyawan">Karyawan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="users[${i}][join_date]">Tanggal Bergabung</label>
            <input type="date" name="users[${i}][join_date]" class="form-control" required>
        </div>`;
    }
</script>
@endsection
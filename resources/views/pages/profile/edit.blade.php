@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Profile</h1>
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
<form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Upload Foto -->
    <div class="form-group text-center">
        <label>Foto Profil</label><br>
        <div class="profile-picture-wrapper">
            <img src="{{ asset('uploads/profile/' . ($user->photo ?? 'defaultProfile.png')) }}" 
                alt="Foto Profil" 
                class="profile-picture">
            <div class="upload-overlay">
                <button type="button" class="btn btn-light btn-sm mb-2" onclick="document.getElementById('photo').click()">
                    <i class="fas fa-upload"></i> Upload
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="removePhoto()">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        </div>
        <input type="file" class="form-control d-none" name="photo" id="photo" accept="image/*">
        <input type="hidden" name="delete_photo" id="delete_photo" value="0">
    </div>


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
    
    <!-- <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" id="role" name="role" required>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="karyawan" {{ $user->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
        </select>
    </div> -->
    <div class="form-group">
        <label for="join_date">Tanggal Bergabung</label>
        <input type="date" class="form-control" id="join_date" name="join_date" value="{{ $user->join_date }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('profile.index') }}" class="btn btn-secondary">Kembali</a>
</form>

<script>
    // Saat file input berubah (upload foto)
    document.getElementById('photo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector('.profile-picture').src = e.target.result;
                document.getElementById('delete_photo').value = 0; // Reset delete kalau sebelumnya dihapus
            }
            reader.readAsDataURL(file);
        }
    });

    function removePhoto() {
        document.getElementById('delete_photo').value = 1;
        document.querySelector('.profile-picture').src = "{{ asset('uploads/profile/defaultProfile.png') }}";
        document.getElementById('photo').value = ""; // reset input file
    }
</script>
@endsection
@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Profile</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Informasi Akun</h6>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Foto Profil -->
            <div class="col-12 col-md-3 profile-picture-container">
                @if(Auth::user()->photo)
                    <img src="{{ asset('uploads/profile/' . Auth::user()->photo) }}"
                        alt="Foto Profil"
                        class="img-fluid rounded-circle shadow text"
                        style="width: 250px; height: 250px; object-fit: cover;">
                @else
                    <img src="{{ asset('uploads/profile/defaultProfile.png') }}"
                        alt="Default Foto"
                        class="img-fluid rounded-circle shadow"
                        style="width: 250px; height: 250px; object-fit: cover;">
                @endif
            </div>
            

            <!-- Data Profil -->
            <div class="col-12 col-md-9">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <th width="25%" class="text-nowrap">NIP</th>
                            <td>: {{ Auth::user()->nip }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Nama</th>
                            <td>: {{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Email</th>
                            <td>:  {{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Jabatan/Departemen</th>
                            <td>: {{ Auth::user()->jobPosition->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-nowrap">Tanggal Bergabung</th>
                            <td>: {{ Auth::user()->join_date }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol aksi -->
    <div class="card-footer d-flex justify-content-between flex-wrap">
        <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
            <i class="fas fa-edit mr-1"></i> Edit Profil
        </a>

        <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
    </div>
</div>

@endsection
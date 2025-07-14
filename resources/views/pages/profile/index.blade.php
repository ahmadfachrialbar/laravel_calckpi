@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0">
            <tr>
                <th style="width: 180px;">NIP</th>
                <td>: {{ Auth::user()->nip }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>: {{ Auth::user()->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>: {{ Auth::user()->email }}</td>
            </tr>
            <tr>
                <th>Jabatan/Departemen</th>
                <td>: {{ Auth::user()->jobPosition->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Bergabung</th>
                <td>: {{ Auth::user()->join_date }}</td>
            </tr>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
    <i class="fas fa-edit mr-1"></i> Edit Profil
</a>

        <a class="btn btn-outline-danger" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-sign-out-alt mr-1"></i> Logout
        </a>
    </div>
</div>
@endsection
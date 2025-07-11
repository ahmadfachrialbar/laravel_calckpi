@extends('layouts.auth')
@section('content')

<div class="bg-login d-flex align-items-center justify-content-center">
    <div class="row shadow-lg w-100" style="max-width: 900px; border-radius: 20px; overflow: hidden;">

        <!-- Kolom Kiri -->
        <div class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4" style="background-color: rgba(255, 192, 203, 0.85);">
            <h3 class="font-weight-bold text-center text-white">Selamat Datang!</h3>
            <p class="font-weight-bold text-center text-white">di Key Performance Indicator</p>
            <img src="{{ asset('template/img/anugrahBeton.png') }}" class="mt-2" style="max-height: 250px; width: 50%; object-fit: contain;" alt="Ilustrasi AB">
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-6 bg-white p-4">
            <div class="text-center mb-3">
                <h5 class="text-primary font-weight-bold">Buat Akun Anda</h5>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger small p-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form class="user" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group mb-2">
                    <input type="text" name="nip" class="form-control form-control-user" placeholder="NIP" required>
                </div>

                <div class="form-group mb-2">
                    <input type="text" name="name" class="form-control form-control-user" placeholder="Nama Lengkap" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 mb-2">
                        <input type="email" name="email" class="form-control form-control-user" placeholder="Email" required>
                    </div>

                    <div class="form-group col-md-6 mb-2">
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Password" required>
                            <div class="input-group-append">
                                <span class="input-group-text form-control form-control-user" style="cursor:pointer;" onclick="togglePassword()">
                                    <i class="fa fa-eye " id="togglePasswordIcon"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pilih Jabatan -->
                <div class="form-group">
                    <label for="job_position_id">Pilih Jabatan/Departemen</label>
                    <select name="job_position_id" id="job_position_id" class="form-control form-control-user" required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach($jobPositions as $job)
                        <option value="{{ $job->id }}">{{ $job->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <input type="date" name="join_date" class="form-control form-control-user" required>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold" style="font-size: 1rem;">
                    Daftar
                </button>
            </form>

            <div class="text-center mt-3">
                <p class="small">Sudah punya akun? <a href="/" class="text-primary font-weight-bold">Login</a></p>
            </div>
        </div>
    </div>
</div>

@endsection
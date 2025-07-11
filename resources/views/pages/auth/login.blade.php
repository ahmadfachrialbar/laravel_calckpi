@extends('layouts.auth')
@section('content')

<div class="bg-login d-flex align-items-center justify-content-center">

    <div class="row shadow-lg w-100" style="max-width: 900px; border-radius: 20px; overflow: hidden;">

        <!-- Kolom Kiri -->
        <div class="col-md-6 text-white d-flex flex-column align-items-center justify-content-center p-4" style="background-color: rgba(255, 192, 203, 0.85);">
            <h3 class="font-weight-bold text-center">Selamat Datang!</h3>
            <p class="text-center font-weight-bold">Di Key Performance Indicator</p>
            <img src="{{ asset('template/img/anugrahBeton.png') }}" class="mt-3" style="max-height: 400px; width: 50%; object-fit: contain;" alt="Ilustrasi AB">
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-6 bg-white p-5">
            <div class="text-center mb-4">
                <h5 class="text-primary font-weight-bold">Login Akun Anda</h5>
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

            <form class="user" method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-user" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Password" required>
                        <div class="input-group-append">
                            <span class="input-group-text form-control form-control-user" style="cursor:pointer;" onclick="togglePassword()">
                                <i class="fa fa-eye " id="togglePasswordIcon"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold" style="font-size: 1rem;">
                    Login
                </button>
            </form>

            <hr>
            <div class="text-center">
                <p class="small">Belum punya akun? <a href="/register" class="text-primary font-weight-bold">Daftar</a></p>
            </div>
        </div>

    </div>
</div>
@endsection
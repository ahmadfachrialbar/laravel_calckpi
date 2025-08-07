@extends('layouts.auth')
@section('content')

<div class="bg-login d-flex align-items-center justify-content-center py-4 py-md-5 px-2 min-vh-100">

    <div class="row shadow-lg w-100 mx-2" style="max-width: 900px; border-radius: 20px; overflow: hidden;">

        <!-- Kolom Kiri - Visible on all devices -->
        <div class="col-md-6 text-white d-flex flex-column align-items-center justify-content-center p-3 p-md-4" style="background-color: rgba(255, 192, 203, 0.85);">
            <div class="text-center mb-3 mb-md-4">
                <h3 class="font-weight-bold">Selamat Datang!</h3>
                <p class="font-weight-bold mb-0">di Calculating KPI PT BABN</p>
            </div>
            <img src="{{ asset('template/img/anugrahBeton.png') }}" class="img-fluid d-md-block" style="max-height: 250px; max-width: 45%; height: auto; object-fit: contain;" alt="Ilustrasi AB">
        </div>

        <!-- Kolom Kanan -->
        <div class="col-md-6 bg-white p-3 p-md-5">
            <div class="text-center mb-3 mb-md-4">
                <h5 class="text-primary font-weight-bold">Login Akun Anda</h5>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="user " method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="form-group mb-3">
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
                <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold py-2" style="font-size: 1rem;">
                    Login
                </button>
            </form>

            <hr class="my-3">
            <div class="text-center">
                <p class="small mb-0">Belum punya akun? <a href="/register" class="text-primary font-weight-bold">Daftar</a></p>
            </div>
        </div>

    </div>
</div>

<script>
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
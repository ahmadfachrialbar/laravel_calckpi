@extends('layouts.auth')
@section('content')

<body class="bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container" style="max-width: 450px;">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-4">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs mb-4" id="authTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="register-tab" data-toggle="tab" href="/register" role="tab">Register</a>
                    </li>
                </ul>
                <!-- Tab Content -->
                <div class="tab-content" id="authTabContent">
                    <!-- Register Form -->
                    <div class="tab-pane fade show active" id="register" role="tabpanel">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Registrasi!</h1>
                        </div>
                        <form class="user">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" placeholder="Nama Lengkap">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" placeholder="Password">
                            </div>
                            <a href="#" class="btn btn-primary btn-user btn-block">
                                Daftar
                            </a>
                        </form>
                        <hr />
                        <div class="text-center">
                            <a class="small" href="/">Sudah Punya Account? Login</a>
                        </div>
                    </div>
                </div>
                @endsection
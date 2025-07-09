@extends('layouts.auth')
@section('content')

<body class="bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 100vh;">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container" style="max-width: 450px;">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-4">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs mb-4" id="authTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="login-tab" data-toggle="tab" href="/" role="tab">Login</a>
                    </li>
                </ul>
                <!-- Tab Content -->
                <div class="tab-content" id="authTabContent">
                    <!-- Login Form -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                        </div>
                        <form class="user" action="/login" method="POST">
                            @csrf
                            @method ('POST')
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                        </form>
                        <hr />
                        <div class="text-center">
                            <a class="small" href="/register">Belum Punya Account? daftar</a>
                        </div>
                    </div>
                    </er
                        @endsection
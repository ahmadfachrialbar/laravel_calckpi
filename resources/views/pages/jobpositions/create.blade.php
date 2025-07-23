@extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola Data Jabatan / Departemen</h1>
</div>
<hr class="divider">

<!-- Create Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Form Tambah Jabatan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('jobpositions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Jabatan / Departemen</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
            <a href="{{ route('jobpositions.index') }}" class="btn btn-secondary mt-2">Batal</a>
        </form>
    </div>
</div>
@endsection
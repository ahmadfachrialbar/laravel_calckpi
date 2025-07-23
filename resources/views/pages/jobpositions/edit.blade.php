@extends('layouts.app')

@section('content')

extends('layouts.app')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola Data Jabatan / Departemen</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Form Edit Jabatan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('jobpositions.update', $position->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Jabatan / Departemen</label>
                <input type="text" name="name" class="form-control" value="{{ $position->name }}" required>
            </div>

            <button class="btn btn-primary mt-3">Update</button>
            <a href="{{ route('jobpositions.index') }}" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>
</div>
@endsection
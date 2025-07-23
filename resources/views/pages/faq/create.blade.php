@extends('layouts.app')

@section('content')
@role('admin')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola Data Panduan/Kontak</h1>
</div>
<hr class="divider">
<form action="{{ route('faq.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Tambah Data Panduan/Kontak</h6>
        </div>
        <div class="form-kpi border rounded p-3">
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Isi Panduan</label>
                <textarea name="isi" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label>Upload File PDF (opsional)</label>
                <input type="file" name="pdf_path" class="form-control-file" accept=".pdf">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('faq.index') }}" class="btn btn-secondary">Kembali</a>
</form>
</div>
@endrole
@endsection
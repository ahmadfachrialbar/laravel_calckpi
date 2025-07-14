@extends('layouts.app')

@section('content')
@role('admin')
<div class="container">
    <h1>Tambah Panduan</h1>
    <form action="{{ route('faq.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
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

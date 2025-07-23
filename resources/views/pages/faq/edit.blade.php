@extends('layouts.app')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola data Panduan/Kontak</h1>
</div>
<hr class="divider">
<form action="{{ route('faq.update', $faq->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card shadow mb-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit Data Panduan /Kontak</h6>
        </div>
        <div class="form-kpi border rounded p-3">
            <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $faq->judul) }}" required>
            </div>

            <div class="form-group">
                <label for="isi">Isi</label>
                <textarea class="form-control" id="isi" name="isi" rows="4" required>{{ old('isi', $faq->isi) }}</textarea>
            </div>

            <div class="form-group">
                <label for="pdf_path">Upload PDF (Opsional)</label>
                <input type="file" class="form-control" name="pdf_path" id="pdf_path">
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('faq.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</form>

@endsection
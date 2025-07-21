@extends('layouts.app')
@section('content')

<h1 class="h3 mb-4 text-gray-700">Edit Panduan</h1>

<form action="{{ route('faq.update', $faq->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div id="form-faq-wrapper">
        <div class="form-faq border rounded p-3 mb-3">
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

        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('faq.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</form>

@endsection
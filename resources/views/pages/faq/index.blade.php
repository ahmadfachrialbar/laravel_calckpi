@extends('layouts.app')

@section('content')

@role('admin')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-2">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Data Panduan Website</h1>
    <a href="{{ route('faq.create') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data
    </a>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white">
        <thead class="thead-light text-center">
            <tr>
                <th>No</th>
                <th>Judul Panduan</th>
                <th>Isi Singkat</th>
                <th>PDF</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($faqs as $index => $faq)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $faq->judul }}</td>
                <td>{{ Str::limit(strip_tags($faq->isi), 100, '...') }}</td>
                <td class="text-center">
                    @if($faq->pdf_path)
                    <i class="fas fa-file-pdf text-danger"></i>
                    @else
                    <span class="text-muted">Tidak tersedia</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($faq->pdf_path)
                    <a href="{{ route('faq.download', $faq->id) }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-download"> </i>
                    </a>
                    @else
                    <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center"><em>Belum ada panduan yang tersedia.</em></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endrole

@role('karyawan')
<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Panduan Penggunaan Website Calculating KPI</h1>

    @forelse($faqs as $faq)
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3 text-primary">
                <i class="fas fa-book-open mr-2"></i>{{ $faq->judul }}
            </h4>

            <div class="card-text mb-3" style="white-space: pre-line;">
                {!! nl2br(e($faq->isi)) !!}
            </div>

            @if($faq->pdf_path)
            <a href="{{ route('faq.download', $faq->id) }}" class="btn btn-outline-success">
                <i class="fas fa-file-download"></i> Unduh Panduan PDF
            </a>
            @endif
        </div>
    </div>
    @empty
    <div class="alert alert-info">
        Belum ada panduan yang tersedia.
    </div>
    @endforelse
</div>
@endrole

@endsection
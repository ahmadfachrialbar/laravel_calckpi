@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit data</h1>
</div>
<!-- form -->
<form action="{{ route('kpimetrics.update', $kpiMetric->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div id="form-kpi-wrapper">
        <div class="form-kpi border rounded p-3 mb-3">
            <div class="form-group">
                <label>Nama KPI</label>
                <input type="text" class="form-control" id="nama_kpi" name="nama_kpi" value="{{ $kpiMetric->nama_kpi }}" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" class="form-control" id="penjelasan_sederhana" name="penjelasan_sederhana" value="{{ $kpiMetric->penjelasan_sederhana }}" required>
            </div>
            <div class="form-group">
                <label>Cara Ukur</label>
                <input type="text" class="form-control" id="cara_ukur" name="cara_ukur" value="{{ $kpiMetric->cara_ukur }}" required>
            </div>
            <div class="form-group">
                <label>Target</label>
                <input type="text" class="form-control" id="target" name="target" value="{{ $kpiMetric->target }}" required>
            </div>
            <div class="form-group">
                <label>Bobot</label>
                <input type="text" class="form-control" id="bobot" name="bobot" value="{{ $kpiMetric->bobot }}" required>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="/kpiMetrics" class="btn btn-secondary" href="">Kembali</button>
</form>
</div>
<!-- End of Main Content -->

@endsection
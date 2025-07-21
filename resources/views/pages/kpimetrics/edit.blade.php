@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Edit data</h1>
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
            <div class="form-group">
                <label for="weightages">Weightages (%)</label>
                <input type="number" name="weightages" id="weightages" class="form-control" value="{{ old('weightages', $kpiMetric->weightages ?? '') }}" step="0.01" required>
            </div>
            <select name="kategori" id="kategori" class="form-control" required>
                <option value="up" {{ $kpiMetric->kategori == 'up' ? 'selected' : '' }}>Up (Semakin tinggi semakin baik)</option>
                <option value="down" {{ $kpiMetric->kategori == 'down' ? 'selected' : '' }}>Down (Semakin rendah semakin baik)</option>
                <option value="zero" {{ $kpiMetric->kategori == 'zero' ? 'selected' : '' }}>Zero (Idealnya 0)</option>
            </select>


        </div>
    </div>

    <button type="submit" class="btn btn-primary mb-4">Simpan</button>
    <button type="/kpiMetrics" class="btn btn-secondary mb-4" href="">Kembali</button>
</form>
</div>
<!-- End of Main Content -->

@endsection
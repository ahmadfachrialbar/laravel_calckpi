@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Tambah Data KPI</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('kpimetrics.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="job_position_id">Jabatan (Optional)</label>
            <select name="job_position_id" id="job_position_id" class="form-control">
                <option value="">-- Pilih Jabatan --</option>
                @foreach ($jobPositions as $position)
                <option value="{{ $position->id }}" {{ old('job_position_id') == $position->id ? 'selected' : '' }}>
                    {{ $position->name }}
                </option>
                @endforeach
            </select>
            <!-- <small class="text-muted">Kosongkan jika KPI khusus user</small> -->
        </div>

        <div class="form-group">
            <label for="user_id">Nama Karyawan</label>
            <select name="user_id" id="user_id" class="form-control">
                <option value="">-- Pilih Karyawan --</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
            <!-- <small class="text-muted">Kosongkan jika KPI berlaku untuk jabatan</small> -->
        </div>

        <div class="form-group">
            <label for="nama_kpi">Nama KPI</label>
            <input type="text" name="nama_kpi" id="nama_kpi" class="form-control" value="{{ old('nama_kpi') }}" required>
        </div>

        <div class="form-group">
            <label for="penjelasan_sederhana">Penjelasan Sederhana</label>
            <textarea name="penjelasan_sederhana" id="penjelasan_sederhana" class="form-control" rows="3" required>{{ old('penjelasan_sederhana') }}</textarea>
        </div>

        <div class="form-group">
            <label for="cara_ukur">Cara Ukur</label>
            <textarea name="cara_ukur" id="cara_ukur" class="form-control" rows="2" required>{{ old('cara_ukur') }}</textarea>
        </div>

        <div class="form-group">
            <label for="target">Target</label>
            <input type="number" name="target" id="target" class="form-control" value="{{ old('target') }}" required>
        </div>

        <div class="form-group">
            <label for="bobot">Actual (%)</label>
            <input type="number" name="bobot" id="bobot" class="form-control" value="{{ old('bobot') }}" required>
        </div>

        <div class="form-group">
            <label for="weightages">Weightages (%)</label>
            <input type="number" name="weightages" id="weightages" class="form-control" value="{{ old('weightages', $kpiMetric->weightages ?? '') }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori Perhitungan</label>
            <select name="kategori" id="kategori" class="form-control" required>
                <option value="up" {{ old('kategori') == 'up' ? 'selected' : '' }}>Up (Increase KPI : Semakin tinggi semakin baik)</option>
                <option value="down" {{ old('kategori') == 'down' ? 'selected' : '' }}>Decrease KPI : Down (Semakin rendah semakin baik)</option>
                <option value="zero" {{ old('kategori') == 'zero' ? 'selected' : '' }}>Zero (Zero Defect KPI: Idealnya 0)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary mb-4">Simpan</button>
        <a href="{{ route('kpimetrics.index') }}" class="btn btn-secondary mb-4">Batal</a>
    </form>
</div>
@endsection
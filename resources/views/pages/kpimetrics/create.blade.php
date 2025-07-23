@extends('layouts.app')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola Data KPI</h1>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@php
$selectedUserId = request()->get('user_id');
$selectedUser = $users->firstWhere('id', $selectedUserId);
@endphp
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Form tambah Data KPI</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('kpimetrics.store') }}" method="POST">
            @csrf

            {{-- Jika user dipilih dari index --}}
            @if($selectedUser)
            <div class="form-group">
                <label for="nama_karyawan">Nama Karyawan</label>
                <input type="text" class="form-control" value="{{ $selectedUser->name }}" readonly>
                <input type="hidden" name="user_id" value="{{ $selectedUser->id }}">
            </div>

            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" class="form-control" value="{{ $selectedUser->jobPosition->name ?? '-' }}" readonly>
            </div>
            @else
            <div class="form-group">
                <label for="user_id">Nama Karyawan</label>
                <select name="user_id" id="user_id" class="form-control" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            @endif


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
                <label for="kategori">Kategori Perhitungan</label>
                <select name="kategori" id="kategori" class="form-control" required>
                    <option value="up" {{ old('kategori') == 'up' ? 'selected' : '' }}>Up (Increase KPI : Semakin tinggi semakin baik)</option>
                    <option value="down" {{ old('kategori') == 'down' ? 'selected' : '' }}>Decrease KPI : Down (Semakin rendah semakin baik)</option>
                    <option value="zero" {{ old('kategori') == 'zero' ? 'selected' : '' }}>Zero (Zero Defect KPI: Idealnya 0)</option>
                </select>
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
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('kpimetrics.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>


@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Edit Nilai KPI</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kpirecords.update', $record->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Karyawan</label>
            <input type="text" class="form-control" value="{{ $record->user->name }}" readonly>
        </div>

        <div class="form-group">
            <label>Nama KPI</label>
            <input type="text" class="form-control" value="{{ $record->kpiMetric->nama_kpi }}" readonly>
        </div>

        <div class="form-group">
            <label>Simulasi Penambahan</label>
            <input type="text" class="form-control" value="{{ $record->simulasi_penambahan }}" readonly>
        </div>

        <div class="form-group">
            <label>Target</label>
            <input type="text" class="form-control" value="{{ $record->kpiMetric->target }}" readonly>
        </div>

        <div class="form-group">
            <label for="achievement">Achievement</label>
            <input type="number" step="0.01" name="achievement" class="form-control" value="{{ old('achievement', $record->achievement) }}" required>
        </div>

        <div class="form-group">
            <label for="weightages">Weightages</label>
            <input type="number" step="0.01" name="weightages" class="form-control" value="{{ old('weightages', $record->weightages) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('kpirecords.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

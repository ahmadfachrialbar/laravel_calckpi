@extends('layouts.app')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Hitung KPI</h1>
<form action="{{ route('kpimetrics.store') }}" method="POST">
    @csrf
    <input type="text" name="nama_kpi" class="form-control" placeholder="Nama KPI">
    <textarea name="penjelasan_sederhana" class="form-control"></textarea>
    <input type="text" name="cara_ukur" class="form-control">
    <input type="number" name="target" class="form-control">
    <input type="number" name="bobot" class="form-control">

    <!-- Tambahkan di sini -->

    <!-- Select Job Position -->
    <div class="form-group mt-3">
        <label for="job_position_id">Pilih Jabatan (optional)</label>
        <select name="job_position_id" class="form-control">
            <option value="">Pilih Jabatan (optional)</option>
            @foreach ($jobPositions as $job)
            <option value="{{ $job->id }}">{{ $job->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Select Specific User -->
    <div class="form-group mt-3">
        <label for="user_id">Pilih User (optional)</label>
        <select name="user_id" class="form-control">
            <option value="">Pilih User (optional)</option>
            @foreach ($users as $u)
            <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>


@endsection
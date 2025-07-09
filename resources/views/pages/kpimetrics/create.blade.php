@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah data</h1>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Data KPI</h6>
    </div>
    <!-- form -->
    <form action="{{ route('kpimetrics.storeMultiple') }}" method="POST">
        @csrf
        <div id="form-kpi-wrapper">
            <div class="form-kpi border rounded p-3 mb-3">
                <div class="form-group">
                    <label>Nama KPI</label>
                    <input type="text" name="kpi[0][nama_kpi]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="kpi[0][penjelasan_sederhana]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Cara Ukur</label>
                    <input type="text" name="kpi[0][cara_ukur]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Target</label>
                    <input type="number" name="kpi[0][target]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Bobot</label>
                    <input type="number" name="kpi[0][bobot]" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary" id="add-form">Next</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="/kpimetrics" class="btn btn-secondary" href="">Kembali</button>
    </form>
    <!-- JavaScript langsung di Blade -->
    <script>
        let index = 0;

        document.getElementById('add-form').addEventListener('click', function() {
            const wrapper = document.getElementById('form-kpi-wrapper');
            const newForm = `
            <div class="form-kpi border rounded p-3 mb-3">
                <div class="form-group">
                    <label>Nama KPI</label>
                    <input type="text" name="kpi[${index}][nama_kpi]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <input type="text" name="kpi[${index}][penjelasan_sederhana]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Cara Ukur</label>
                    <input type="text" name="kpi[${index}][cara_ukur]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Target</label>
                    <input type="number" name="kpi[${index}][target]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Bobot</label>
                    <input type="number" name="kpi[${index}][bobot]" class="form-control" required>
                </div>
            </div>
        `;
            wrapper.insertAdjacentHTML('beforeend', newForm);
            index++;
        });

    </script>
</div>

<!-- End of Main Content -->

@endsection
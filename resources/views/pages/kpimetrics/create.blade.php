@extends('layouts.app')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-2 text-gray-700 font-weight-bold">Kelola Data KPI</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Form tambah Data KPI</h6>
    </div>
    <div class="card-body">
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

        <form action="{{ route('kpimetrics.storeMultiple') }}" method="POST">
            @csrf
            <div id="form-kpi-wrapper">
                <div class="form-kpi border rounded p-3 mb-3">
                    {{-- Jika user dipilih dari index --}}
                    @if($selectedUser)
                    <div class="form-group">
                        <label for="nama_karyawan">Nama Karyawan</label>
                        <input type="text" class="form-control" value="{{ $selectedUser->name }}" readonly>
                        <input type="hidden" name="kpis[0][user_id]" value="{{ $selectedUser->id }}">
                    </div>

                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" value="{{ $selectedUser->jobPosition->name ?? '-' }}" readonly>
                    </div>
                    @else
                    <div class="form-group">
                        <label for="user_id">Nama Karyawan</label>
                        <select name="kpis[0][user_id]" class="form-control" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('kpis.0.user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="form-group">
                        <label for="nama_kpi">Nama KPI</label>
                        <input type="text" name="kpis[0][nama_kpi]" class="form-control" value="{{ old('kpis.0.nama_kpi') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="penjelasan_sederhana">Deskripsi</label>
                        <textarea name="kpis[0][penjelasan_sederhana]" class="form-control" rows="3" required>{{ old('kpis.0.penjelasan_sederhana') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="cara_ukur">Cara Ukur</label>
                        <textarea name="kpis[0][cara_ukur]" class="form-control" rows="2" required>{{ old('kpis.0.cara_ukur') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori Perhitungan</label>
                        <select name="kpis[0][kategori]" class="form-control" required>
                            <option value="up" {{ old('kpis.0.kategori') == 'up' ? 'selected' : '' }}>Up (Increase KPI : Semakin tinggi semakin baik)</option>
                            <option value="down" {{ old('kpis.0.kategori') == 'down' ? 'selected' : '' }}>Decrease KPI : Down (Semakin rendah semakin baik)</option>
                            <option value="zero" {{ old('kpis.0.kategori') == 'zero' ? 'selected' : '' }}>Zero (Zero Defect KPI: Idealnya 0)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="target">Target</label>
                        <input type="number" name="kpis[0][target]" class="form-control" value="{{ old('kpis.0.target') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="bobot">Actual (%)</label>
                        <input type="number" name="kpis[0][bobot]" class="form-control" value="{{ old('kpis.0.bobot') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="weightages">Weightages (%)</label>
                        <input type="number" name="kpis[0][weightages]" class="form-control" value="{{ old('kpis.0.weightages') }}" step="0.01" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary" id="add-kpi-form">Tambah Form KPI</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('kpimetrics.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    let kpiIndex = 1;
    let selectedUserId = document.querySelector('[name="kpis[0][user_id]"]')?.value || '{{ $selectedUserId ?? "" }}';
    let selectedUserName = @json($selectedUser ? $selectedUser->name : '');
    document.getElementById('add-kpi-form').addEventListener('click', function () {
        const wrapper = document.getElementById('form-kpi-wrapper');
        wrapper.insertAdjacentHTML('beforeend', generateKpiFormFields(kpiIndex));
        kpiIndex++;
    });

    function generateKpiFormFields(i) {
        return `
        <div class="form-kpi border rounded p-3 mb-3">

            ${selectedUserId ? `
            <div class="form-group">
                <label for="nama_karyawan">Nama Karyawan</label>
                <input type="text" class="form-control" value="${selectedUserName}" readonly>
                <input type="hidden" name="kpis[${i}][user_id]" value="${selectedUserId}">
            </div>` : `
            <div class="form-group">
                <label for="user_id">Nama Karyawan</label>
                <select name="kpis[${i}][user_id]" class="form-control" required>
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>`}

            <div class="form-group">
                <label for="nama_kpi">Nama KPI</label>
                <input type="text" name="kpis[${i}][nama_kpi]" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="penjelasan_sederhana">Deskripsi</label>
                <textarea name="kpis[${i}][penjelasan_sederhana]" class="form-control" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="cara_ukur">Cara Ukur</label>
                <textarea name="kpis[${i}][cara_ukur]" class="form-control" rows="2" required></textarea>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori Perhitungan</label>
                <select name="kpis[${i}][kategori]" class="form-control" required>
                    <option value="up">Up (Semakin tinggi semakin baik)</option>
                    <option value="down">Down (Semakin rendah semakin baik)</option>
                    <option value="zero">Zero (Idealnya 0)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="target">Target</label>
                <input type="number" name="kpis[${i}][target]" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="bobot">Actual (%)</label>
                <input type="number" name="kpis[${i}][bobot]" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="weightages">Weightages (%)</label>
                <input type="number" name="kpis[${i}][weightages]" class="form-control" step="0.01" required>
            </div>
        </div>`;
    }

</script>
@endsection
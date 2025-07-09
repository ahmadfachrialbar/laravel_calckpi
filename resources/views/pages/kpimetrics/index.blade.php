@extends('layouts.app')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Data KPI</h1>
    <a href="{{route('kpimetrics.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data KPI</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama KPI</th>
                        <th>Deskripsi</th>
                        <th>Cara Ukur</th>
                        <th>Target</th>
                        <th>Bobot</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kpiMetrics as $kpimetric)
                    <tr>
                        <td>{{ $kpimetric->id }}</td>
                        <td>{{ $kpimetric->nama_kpi }}</td>
                        <td>{{ $kpimetric->penjelasan_sederhana }}</td>
                        <td>{{ $kpimetric->cara_ukur }}</td>
                        <td>{{ $kpimetric->target }}</td>
                        <td>{{ $kpimetric->bobot }}</td>
                        <td>
                            <!-- Aksi -->
                            <div class="d-flex justify-content-center" style="gap: 0.5rem;">
                                <!-- Tombol Lihat -->
                                <a href="{{ route('kpimetrics.show', ['id' => $kpimetric->id]) }}" class="btn btn-link p-0 text-info" title="Lihat KPI">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Tombol Edit -->
                                <a href="{{ route('kpimetrics.edit', ['id' => $kpimetric->id]) }}" class="btn btn-link p-0 text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('kpimetrics.destroy', $kpimetric->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- End of Main Content -->
@endsection
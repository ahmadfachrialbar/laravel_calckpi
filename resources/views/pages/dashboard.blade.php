@extends('layouts.app')

@section('content')

<div class="dashboard-bg">
    <div class="container dashboard-content py-6">
        {{-- Header --}}
        <div class="d-flex flex-column flex-md-row align-items-start justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-2 text-white font-weight-bold">
                    Welcome, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-white mb-0">Selamat datang di Website Calculating KPI PT Anugrah Beton Nusantara</p>
            </div>
            <a href="{{ route('laporan.admin.download') }}" class="btn btn-sm btn-secondary shadow-sm mt-3 mt-md-0">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>

        {{-- Statistik Card --}}
        @hasanyrole('admin|direksi')
        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Karyawan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKaryawan ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endhasanyrole

        @role('karyawan')
        <div class="row">
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total KPI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKpi ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Score</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalScore, 2) }}%</div>
                    </div>
                </div>
            </div>
        </div>
        @endrole

        @hasanyrole('admin|direksi')
        <div class="row">
            <div class="col-xl-12 col-md-12 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <h5 class="font-weight-bold text-primary">Grafik Score Seluruh Karyawan</h5>

                        <div class="form-group">
                            <label for="searchKaryawan">Cari Nama / Departemen:</label>
                            <input type="text" id="searchKaryawan" class="form-control" placeholder="Masukkan nama atau departemen">
                        </div>

                        <canvas id="karyawanScoreChart" height="100"></canvas>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button id="prevPage" class="btn btn-outline-primary btn-sm">Prev</button>
                            <span id="pageInfo">Page 1</span>
                            <button id="nextPage" class="btn btn-outline-primary btn-sm">Next</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @endhasanyrole
    </div>
</div>
@endsection

@hasanyrole('admin|direksi')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("karyawanScoreChart").getContext("2d");

        const rawData = @json($karyawanScores);
        let currentPage = 0;
        const itemsPerPage = 10;

        function getPageData(data, page) {
            const start = page * itemsPerPage;
            return data.slice(start, start + itemsPerPage);
        }

        function renderChart(dataSubset) {
            const labels = dataSubset.map(item => item.name || 'Tidak diketahui');
            const scores = dataSubset.map(item => {
                const score = parseFloat(item.total_score);
                return isNaN(score) || score < 0 ? 0 : score;
            });

            const backgroundColors = scores.map(score =>
                score === 0 ? "rgba(255, 99, 132, 0.5)" : "rgba(78, 115, 223, 0.5)"
            );
            const borderColors = scores.map(score =>
                score === 0 ? "rgba(255, 99, 132, 1)" : "rgba(78, 115, 223, 1)"
            );

            chart.data.labels = labels;
            chart.data.datasets[0].data = scores;
            chart.data.datasets[0].backgroundColor = backgroundColors;
            chart.data.datasets[0].borderColor = borderColors;
            chart.update();
        }

        const chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [],
                datasets: [{
                    label: "Total Score (%)",
                    data: [],
                    backgroundColor: [],
                    borderColor: [],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        function updatePage() {
            const filtered = getFilteredData();
            const maxPage = Math.ceil(filtered.length / itemsPerPage);
            currentPage = Math.max(0, Math.min(currentPage, maxPage - 1));

            const pageData = getPageData(filtered, currentPage);
            renderChart(pageData);

            document.getElementById("pageInfo").textContent = `Page ${currentPage + 1} of ${maxPage}`;
        }

        function getFilteredData() {
            const keyword = document.getElementById("searchKaryawan").value.toLowerCase();
            return rawData.filter(item =>
                item.name.toLowerCase().includes(keyword) ||
                item.jabatan.toLowerCase().includes(keyword)
            );
        }

        document.getElementById("searchKaryawan").addEventListener("input", function () {
            currentPage = 0;
            updatePage();
        });

        document.getElementById("prevPage").addEventListener("click", function () {
            currentPage--;
            updatePage();
        });

        document.getElementById("nextPage").addEventListener("click", function () {
            currentPage++;
            updatePage();
        });

        updatePage(); // initial render
    });
</script>
@endhasanyrole

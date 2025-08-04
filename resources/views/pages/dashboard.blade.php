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
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total KPI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKpi ?? 0 }}</div>
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

                        <!-- Chart container with optimized dimensions -->
                        <div id="chart-container" style="position: relative; height: 500px;">
                            <canvas id="karyawanScoreChart"></canvas>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <button id="prevPage" class="btn btn-outline-primary btn-sm">Prev</button>
                            <span id="pageInfo">Page 1 of 1</span>
                            <button id="nextPage" class="btn btn-outline-primary btn-sm">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endhasanyrole
    </div>
</div>

<style>
    /* Custom styling for the chart */
    #chart-container {
        height: 500px;
        margin: 0 auto;
    }
    
    #karyawanScoreChart {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Card styling */
    .card {
        border-radius: 0.35rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    /* Button styling */
    .btn-outline-primary {
        color: #4e73df;
        border-color: #4e73df;
    }
    
    .btn-outline-primary:hover {
        background-color: #4e73df;
        color: white;
    }
</style>

@endsection

@hasanyrole('admin|direksi')
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("karyawanScoreChart").getContext("2d");

    // Format data and ensure values are between 0-100
    const rawData = @json($karyawanScores).map(item => ({
        ...item,
        total_score: Math.max(0, Math.min(100, parseFloat(item.total_score) || 0))
    }));

    let currentPage = 0;
    const itemsPerPage = 10; // Set exactly 10 items per page
    let chartInstance = null;

    // Chart initialization
    function initializeChart() {
        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [],
                datasets: [{
                    label: "Total Score (%)",
                    data: [],
                    backgroundColor: "#4e73df",
                    borderColor: "#4e73df",
                    borderWidth: 1,
                    borderRadius: 4,
                    barThickness: 30 // Fixed bar thickness for 10 items
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 0
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 100,
                        grid: {
                            drawBorder: false,
                            color: "rgba(0, 0, 0, 0.1)"
                        },
                        ticks: {
                            stepSize: 20,
                            padding: 10,
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Total Score (%)',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            autoSkip: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: "#4e73df",
                        titleFont: {
                            weight: 'bold',
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Score: ' + context.parsed.y.toFixed(1) + '%';
                            }
                        }
                    }
                },
                layout: {
                    padding: {
                        top: 15,
                        right: 15,
                        bottom: 15,
                        left: 15
                    }
                }
            }
        });
    }

    function getPageData(data, page) {
        const start = page * itemsPerPage;
        return data.slice(start, start + itemsPerPage);
    }

    function getFilteredData() {
        const keyword = document.getElementById("searchKaryawan").value.toLowerCase();
        return rawData.filter(item =>
            item.name.toLowerCase().includes(keyword) ||
            (item.jabatan && item.jabatan.toLowerCase().includes(keyword))
        );
    }

    function updateChart(dataSubset) {
        chartInstance.data.labels = dataSubset.map(item => item.name);
        chartInstance.data.datasets[0].data = dataSubset.map(item => item.total_score);
        chartInstance.update();
    }

    function updatePage() {
        const filtered = getFilteredData();
        const maxPage = Math.max(1, Math.ceil(filtered.length / itemsPerPage));
        currentPage = Math.max(0, Math.min(currentPage, maxPage - 1));
        
        const pageData = getPageData(filtered, currentPage);
        updateChart(pageData);

        document.getElementById("pageInfo").textContent = `Page ${currentPage + 1} of ${maxPage}`;
        document.getElementById("prevPage").disabled = currentPage === 0;
        document.getElementById("nextPage").disabled = currentPage >= maxPage - 1 || maxPage === 1;
    }

    // Event listeners
    let searchTimeout;
    document.getElementById("searchKaryawan").addEventListener("input", function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 0;
            updatePage();
        }, 300);
    });

    document.getElementById("prevPage").addEventListener("click", function() {
        if (currentPage > 0) {
            currentPage--;
            updatePage();
        }
    });

    document.getElementById("nextPage").addEventListener("click", function() {
        const filtered = getFilteredData();
        const maxPage = Math.ceil(filtered.length / itemsPerPage);
        if (currentPage < maxPage - 1) {
            currentPage++;
            updatePage();
        }
    });

    // Initial render
    initializeChart();
    updatePage();
});
</script>
@endsection
@endhasanyrole
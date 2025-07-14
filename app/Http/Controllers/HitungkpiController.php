<?php

namespace App\Http\Controllers;

use App\Models\KpiMetrics;
use App\Models\KpiRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HitungkpiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil KPI dari jabatan user
        $kpis = $user->jobPosition?->kpiMetrics ?? collect();

        // Ambil riwayat perhitungan KPI milik user
        $records = KpiRecord::where('user_id', $user->id)
            ->with('kpiMetric')
            ->get();

        return view('pages.hitungkpi.index', compact('kpis', 'records', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi struktur input
        if (!is_array($request->kpi)) {
            return back()->withErrors(['error' => 'Format data KPI tidak valid.']);
        }

        foreach ($request->kpi as $item) {
            $kpiMetric = KpiMetrics::find($item['metric_id']);

            // Pastikan KPI valid & sesuai jabatan user
            if ($kpiMetric && $user->job_position_id == $kpiMetric->job_position_id) {
                $simulasi = floatval($item['simulasi_penambahan']);
                $target = floatval($kpiMetric->target) ?: 1; // Hindari pembagian 0
                $bobot = floatval($kpiMetric->bobot);
                $weightages = floatval($kpiMetric->weightages); // ambil dari tabel KPI Metrics

                // Hitung nilai KPI
                $weightages = floatval($kpiMetric->weightages);
                $achievement = $simulasi / $target;
                $score = $achievement * $weightages;


                // Simpan ke kpi_records
                KpiRecord::create([
                    'user_id' => $user->id,
                    'kpimetrics_id' => $kpiMetric->id,
                    'simulasi_penambahan' => $simulasi,
                    'achievement' => number_format($achievement, 2),
                    'score' => number_format($score, 2),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Perhitungan KPI berhasil disimpan.');
        
    }
}

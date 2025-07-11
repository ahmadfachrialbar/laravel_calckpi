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

        // Ambil KPI berdasarkan job position (bukan KPI khusus user)
        $kpis = $user->jobPosition?->kpiMetrics ?? collect(); // safe default

        // Ambil record KPI milik user untuk ditampilkan
        $records = KpiRecord::where('user_id', $user->id)
                    ->with('kpiMetric')
                    ->get();

        return view('pages.hitungkpi.index', compact('kpis', 'records', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!is_array($request->kpi)) {
            return back()->withErrors(['error' => 'Data KPI tidak valid.']);
        }

        foreach ($request->kpi as $item) {
            $kpiMetric = KpiMetrics::find($item['metric_id']);

            if ($kpiMetric && $user->jobPosition && $kpiMetric->job_position_id == $user->job_position_id) {
                $realization = floatval($item['realization']);
                $target = floatval($kpiMetric->target) ?: 1; // Hindari bagi 0
                $bobot = floatval($kpiMetric->bobot);

                $score = ($realization / $target) * $bobot;

                KpiRecord::create([
                    'user_id' => $user->id,
                    'kpimetrics_id' => $kpiMetric->id,
                    'realization' => $realization,
                    'score' => number_format($score, 2),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data KPI berhasil dihitung.');
    }
}

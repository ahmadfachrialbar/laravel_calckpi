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

        // Ambil semua KPI Metrics
        $kpis = KpiMetrics::all();

        // Ambil data record KPI user saat ini
        $records = KpiRecord::where('user_id', $user->id)->with('kpiMetric')->get();

        return view('pages.hitungkpi.index', compact('kpis', 'records', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        foreach ($request->kpi as $index => $item) {
            $kpiMetric = KpiMetrics::find($item['metric_id']);

            if ($kpiMetric) {
                $score = ($item['realization'] / $kpiMetric->target) * $kpiMetric->bobot;

                KpiRecord::create([
                    'user_id' => $user->id,
                    'kpimetrics_id' => $kpiMetric->id,
                    'realization' => $item['realization'],
                    'score' => number_format($score, 2),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data KPI berhasil dihitung.');
    }
}

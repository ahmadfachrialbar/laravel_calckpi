<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KpiRecord;
use App\Models\KpiMetrics;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $totalKaryawan = User::count();
            $totalKpi = KpiMetrics::count();

            // ✅ Logika disamakan dengan laporanAdmin di HitungkpiController
            $karyawanScores = User::role('karyawan')
                ->with(['jobPosition', 'kpiRecords'])
                ->get()
                ->map(function ($user) {
                    $totalScore = $user->kpiRecords
                        ->groupBy('kpimetrics_id')
                        ->map(fn($items) => $items->sortByDesc('created_at')->first())
                        ->sum('score');

                    return [
                        'name' => $user->name,
                        'jabatan' => $user->jobPosition->name ?? '-',
                        'total_score' => round($totalScore, 2),
                    ];
                });

            return view('pages.dashboard', [
                'totalKaryawan' => $totalKaryawan,
                'totalKpi' => $totalKpi,
                'totalUserKpi' => null,
                'totalScore' => null,
                'recentKpi' => collect(),
                'karyawanScores' => $karyawanScores,
            ]);
        }

        // ✅ Untuk karyawan (tanpa perubahan)
        $userId = auth()->id();
        $totalKpi = KpiMetrics::where('user_id', $userId)->count();
        $totalUserKpi = KpiRecord::where('user_id', $userId)->count();
        $totalScore = KpiRecord::where('user_id', $userId)
            ->get()
            ->groupBy('kpimetrics_id')
            ->map(fn($items) => $items->sortByDesc('created_at')->first())
            ->sum('score');


        $recentKpi = KpiRecord::where('user_id', $userId)
            ->with('kpiMetric')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard', [
            'totalKaryawan' => null,
            'totalKpi' => $totalKpi,
            'totalUserKpi' => $totalUserKpi,
            'totalScore' => $totalScore,
            'recentKpi' => $recentKpi,
            'karyawanScores' => collect(),
        ]);
    }
}

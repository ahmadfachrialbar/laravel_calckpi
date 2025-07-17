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

            // ✅ Data untuk diagram batang admin
            $karyawanScores = User::with('jobPosition')
                ->whereHas('roles', fn($q) => $q->where('name', 'karyawan'))
                ->get()
                ->map(function ($user) {
                    $totalScore = KpiRecord::where('user_id', $user->id)->avg('score') ?? 0;
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
        $totalScore = KpiRecord::where('user_id', $userId)->avg('score') ?? 0;
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
            'karyawanScores' => collect(), // biar tidak error di blade
        ]);
    }
}

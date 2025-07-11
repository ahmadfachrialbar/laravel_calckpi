<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\Concerns\Has;


class DashboardController extends Controller
{

    public function index()
    {

        /** @var User $user */
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $totalKaryawan = \App\Models\User::role('karyawan')->count();
            $totalKpi = \App\Models\Kpimetrics::count();

            return view('pages.dashboard', compact('totalKaryawan', 'totalKpi', 'user'));
        }

        if ($user->hasRole('karyawan')) {
            $userKpi = $user->jobPosition?->kpiMetrics ?? collect();
            $totalUserKpi = $userKpi->count();

            return view('pages.dashboard', compact('totalUserKpi', 'user'));
        }

        abort(403);
    }
}

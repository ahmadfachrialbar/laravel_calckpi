<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpimetrics;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPosition;

class KpimetricController extends Controller
{
    // public function index()
    // {
    //     $kpiMetrics = Kpimetrics::all();
    //     return view('pages.kpimetrics.index', [
    //         'kpiMetrics' => $kpiMetrics,
    //     ]);
    // }

    public function index()
    {
        $user = Auth()->user();

        if ($user->hasRole('admin')) {
            $karyawan = User::role('karyawan')
                ->with('jobPosition.kpiMetrics')
                ->get();

            return view('pages.kpimetrics.index', compact('karyawan'));
        }

        if ($user->hasRole('karyawan')) {
            $kpiMetrics = $user->jobPosition?->kpiMetrics ?? [];

            return view('pages.kpimetrics.index', compact('kpiMetrics'));
        }

        abort(403);
    }


    public function create()
    {
        $jobPositions = JobPosition::all();
        $users = User::role('karyawan')->get();

        return view('pages.kpimetrics.create', compact('jobPositions', 'users'));
    }


    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'nama_kpi' => 'required|string|max:255',
    //         'penjelasan_sederhana' => 'required|string|max:500',
    //         'cara_ukur' => 'required|string|max:500',
    //         'target' => 'required|numeric',
    //         'bobot' => 'required|numeric',
    //     ]);

    //     Kpimetrics::create($validated);
    //     return redirect('/kpiMetrics')->with('success', 'Data KPI Metrics berhasil ditambahkan');
    // }

    // fungsi store  agar bisa tambah banyak data sekaligus
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kpi' => 'required',
            'penjelasan_sederhana' => 'required',
            'cara_ukur' => 'required',
            'target' => 'required|numeric',
            'bobot' => 'required|numeric',
            'job_position_id' => 'nullable|exists:job_positions,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        KpiMetrics::create($validated);
        return redirect()->route('kpimetrics.index')->with('success', 'Data KPI berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kpiMetric = Kpimetrics::findOrFail($id);
        return view('pages.kpimetrics.edit', [
            'kpiMetric' => $kpiMetric,
        ]);
    }

    public function update(Request $request, $id)
    {
        $kpiMetric = Kpimetrics::findOrFail($id);

        $request->validate([
            'nama_kpi' => 'required|string|max:255',
            'penjelasan_sederhana' => 'required|string|max:500',
            'cara_ukur' => 'required|string|max:500',
            'target' => 'required|numeric',
            'bobot' => 'required|numeric',
        ]);

        $kpiMetric->update($request->all());
        return redirect()->route('kpimetrics.index')->with('success', 'Data KPI Metrics berhasil diperbarui');
    }

    public function show($id)
    {
        $kpiMetric = Kpimetrics::findOrFail($id);
        return view('pages.kpimetrics.show', [
            'kpiMetric' => $kpiMetric,
        ]);
    }

    public function destroy($id)
    {
        $kpiMetric = Kpimetrics::findOrFail($id);
        $kpiMetric->delete();
        return redirect()->route('kpimetrics.index')->with('success', 'Data KPI Metrics berhasil dihapus');
    }
}

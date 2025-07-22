<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpimetrics;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPosition;


class KpimetricController extends Controller
{
    public function index()
    {
        $user = Auth()->user();

        if ($user->hasRole('admin')) {
            $karyawan = User::role('karyawan')
                ->with('jobPosition.kpiMetrics', 'kpiMetrics')
                ->get();

            // Ambil KPI yang tidak punya relasi user maupun job_position (orphan data)
            $kpiOrphan = Kpimetrics::whereNull('user_id')
                ->whereNull('job_position_id')
                ->get();

            return view('pages.kpimetrics.index', compact('karyawan', 'kpiOrphan'));
        }

        if ($user->hasRole('karyawan')) {
            $jobKpis = $user->jobPosition->kpiMetrics ?? collect();
            $userKpis = $user->kpiMetrics ?? collect();

            // Gabungkan KPI dari jabatan dan KPI khusus user
            $kpiMetrics = $jobKpis->merge($userKpis);

            return view('pages.kpimetrics.index', compact('kpiMetrics'));
        }
        abort(403);
    }




    public function create()
    {
        $jobPositions = JobPosition::where('id', '!=', 9)->get();
        $users = User::role('karyawan')->get(); // ambil user yang role-nya karyawan
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
            'nama_kpi' => 'required|string|max:255',
            'penjelasan_sederhana' => 'required|string|max:500',
            'cara_ukur' => 'required|string|max:500',
            'target' => 'required|numeric',
            'bobot' => 'required|numeric',
            'job_position_id' => 'nullable|exists:job_positions,id',
            'user_id' => 'nullable|exists:users,id',
            'weightages' => 'required|numeric|min:0',
            'kategori' => 'required|in:up,down,zero',
        ]);

        // Pastikan minimal satu dari job_position_id atau user_id diisi
        if (empty($validated['job_position_id']) && empty($validated['user_id'])) {
            return back()->withErrors('Pilih salah satu: jabatan atau user.');
        }

        KpiMetrics::create($validated);

        notify()->success('Data KPI berhasil ditambahkan', 'Sukses');

        return redirect()->route('kpimetrics.index');
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
            'weightages' => 'required|numeric|min:0',
            'kategori' => 'required|in:up,down,zero',
        ]);

        $kpiMetric->update($request->all());
        notify()->success('Data KPI berhasil Diperbarui', 'Sukses');
        return redirect()->route('kpimetrics.index');
    }

    public function show($id)
    {
        $user = User::with(['jobPosition', 'kpiMetrics'])->findOrFail($id);

        // Ambil hanya KPI yang diinputkan secara langsung untuk user ini
        $kpiMetrics = $user->kpiMetrics;

        return view('pages.kpimetrics.show', compact('user', 'kpiMetrics'));
    }


    public function destroy($id)
    {
        $kpiMetric = Kpimetrics::findOrFail($id);
        $kpiMetric->delete();
        notify()->success('Data KPI berhasil dihapus', 'Sukses');
        return redirect()->route('kpimetrics.index');
    }
}
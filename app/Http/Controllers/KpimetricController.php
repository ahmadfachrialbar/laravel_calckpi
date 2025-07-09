<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpimetrics;


class KpimetricController extends Controller
{
    public function index()
    {
        $kpiMetrics = Kpimetrics::all();
        return view('pages.kpimetrics.index', [
            'kpiMetrics' => $kpiMetrics,
        ]);
    }

    public function create()
    {
        return view('pages.kpimetrics.create');
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

    // fungsi store multiple agar bisa tambah banyak data sekaligus
    public function storeMultiple(Request $request)
    {
        $data = $request->input('kpi');

        foreach ($data as $item) {
            Kpimetrics::create([
                'nama_kpi' => $item['nama_kpi'],
                'penjelasan_sederhana' => $item['penjelasan_sederhana'],
                'cara_ukur' => $item['cara_ukur'],
                'target' => $item['target'],
                'bobot' => $item['bobot'],
            ]);
        }

        return redirect()->route('kpimetrics.index')->with('success', 'Data KPI berhasil disimpan.');
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

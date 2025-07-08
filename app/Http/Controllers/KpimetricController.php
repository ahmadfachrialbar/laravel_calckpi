<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpimetrics; 


class KpimetricController extends Controller
{
    public function index()
    {
        // Mengambil semua data dari model Kpimetric
        $kpimetrics = Kpimetrics::all();

        // Mengembalikan view dengan data yang diambil
        return view('pages.kpi.index', compact('kpimetrics'));
    }

    public function create()
    {
        // Mengembalikan view untuk form tambah data
        return view('pages.kpi.create');
    }   

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama_kpi' => 'required|string|max:255',
            'penjelasan_sederhana' => 'required|string',
            'cara_ukur' => 'required|string',
            'target' => 'required|numeric',
            'bobot' => 'required|numeric',
        ]);

        // Membuat instance baru dari model Kpimetric
        $kpiMetric = new Kpimetrics();
        $kpiMetric->nama_kpi = $request->nama_kpi;
        $kpiMetric->penjelasan_sederhana = $request->penjelasan_sederhana;
        $kpiMetric->cara_ukur = $request->cara_ukur;
        $kpiMetric->target = $request->target;
        $kpiMetric->bobot = $request->bobot;

        // Menyimpan data ke database
        $kpiMetric->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kpi.index')->with('success', 'KPI Metric created successfully.');
    }

    public function edit($id)
    {
        // Mengambil data berdasarkan ID
        $kpiMetric = Kpimetrics::findOrFail($id);

        // Mengembalikan view untuk form edit dengan data yang diambil
        return view('pages.kpi.edit', compact('kpiMetric'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama_kpi' => 'required|string|max:255',
            'penjelasan_sederhana' => 'required|string',
            'cara_ukur' => 'required|string',
            'target' => 'required|numeric',
            'bobot' => 'required|numeric',
        ]);

        // Mengambil data berdasarkan ID
        $kpiMetric = Kpimetrics::findOrFail($id);
        $kpiMetric->nama_kpi = $request->nama_kpi;
        $kpiMetric->penjelasan_sederhana = $request->penjelasan_sederhana;
        $kpiMetric->cara_ukur = $request->cara_ukur;
        $kpiMetric->target = $request->target;
        $kpiMetric->bobot = $request->bobot;

        // Menyimpan perubahan ke database
        $kpiMetric->save();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kpi.index')->with('success', 'KPI Metric updated successfully.');
    }

    public function destroy($id)
    {
        // Mengambil data berdasarkan ID
        $kpiMetric = Kpimetrics::findOrFail($id);

        // Menghapus data dari database
        $kpiMetric->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kpi.index')->with('success', 'KPI Metric deleted successfully.');
    }

    public function show($id)
    {
        // Mengambil data berdasarkan ID
        $kpiMetric = Kpimetrics::findOrFail($id);

        // Mengembalikan view untuk menampilkan detail KPI Metric
        return view('pages.kpi.show', compact('kpiMetric'));
    }

    public function search(Request $request)
    {
        // Mengambil query pencarian dari input
        $query = $request->input('query');

        // Mencari KPI Metrics berdasarkan nama_kpi
        $kpimetrics = Kpimetrics::where('nama_kpi', 'like', '%' . $query . '%')->get();

        // Mengembalikan view dengan hasil pencarian
        return view('pages.kpi.index', compact('kpimetrics'));
    }


}

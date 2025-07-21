<?php

namespace App\Http\Controllers;

use App\Models\KpiRecord;
use App\Models\KpiMetrics;
use App\Models\User;
use Illuminate\Http\Request;

class KpiRecordController extends Controller
{
    // Admin melihat seluruh riwayat hitung KPI semua karyawan
    public function index()
    {
        $records = KpiRecord::with(['user', 'kpiMetric'])->get();
        return view('pages.kpirecords.index', compact('records'));
    }

    // // Form edit weightages & achievement (oleh admin)
    // public function edit($id)
    // {
    //     $record = KpiRecord::with(['user', 'kpiMetric'])->findOrFail($id);
    //     return view('pages.laporan.edit', compact('record'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'achievement' => 'required|numeric|min:0',
    //         'weightages' => 'required|numeric|min:0',
    //     ]);

    //     $record = KpiRecord::findOrFail($id);

    //     $record->achievement = $request->achievement;
    //     $record->weightages = $request->weightages;
    //     $record->score = $request->achievement * $request->weightages;

    //     $record->save();

    //     notify()->success('Data KPI Record berhasil diperbarui', 'Sukses');
    //     return redirect()->route('laporan.index');
    // }

    public function destroy($id)
    {
        $record = KpiRecord::findOrFail($id);
        $record->delete();

        notify()->success('Data KPI Record berhasil dihapus', 'Sukses');
        return redirect()->route('kpirecords.index');
    }
}
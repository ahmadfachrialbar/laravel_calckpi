<?php

namespace App\Http\Controllers;

use App\Models\KpiRecord;
use Illuminate\Http\Request;

class KpiRecordController extends Controller
{
    /**
     * Menampilkan seluruh riwayat perhitungan KPI semua karyawan
     */
    public function index()
    {
        // Ambil semua record KPI lengkap dengan relasi user dan kpiMetric
        $records = KpiRecord::with(['user.jobPosition', 'kpiMetric'])
            ->latest()
            ->get();

        return view('pages.kpirecords.index', compact('records'));
    }

    /**
     * Menghapus riwayat perhitungan KPI tertentu
     */
    public function destroy($id)
    {
        $record = KpiRecord::findOrFail($id);
        $record->delete();

        notify()->success('Data KPI Record berhasil dihapus', 'Sukses');
        return redirect()->route('kpirecords.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\KpiMetrics;
use App\Models\KpiRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HitungkpiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil KPI dari jabatan user
        $kpis = $user->jobPosition?->kpiMetrics ?? collect();

        // Ambil riwayat KPI terbaru per KPI (hanya 1 record terakhir per KPI)
        $records = KpiRecord::where('user_id', $user->id)
            ->with('kpiMetric')
            ->latest()
            ->get()
            ->groupBy('kpimetrics_id')
            ->map(fn($items) => $items->first());

        return view('pages.hitungkpi.index', compact('kpis', 'records', 'user'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        if (!is_array($request->kpi)) {
            return back()->withErrors(['error' => 'Format data KPI tidak valid.']);
        }

        foreach ($request->kpi as $item) {
            $kpiMetric = KpiMetrics::find($item['metric_id']);

            if ($kpiMetric && $user->job_position_id == $kpiMetric->job_position_id) {
                $simulasi = floatval($item['simulasi_penambahan']);
                $bobot = floatval($kpiMetric['bobot']);
                $target = floatval($kpiMetric->target) ?: 1;
                $weightages = floatval($kpiMetric->weightages);

                // ✅ Rumus sesuai Excel
                $achievement = (($simulasi + $bobot) / $target) * 100;
                $score = ($achievement * $weightages) / 100;

                // Simpan ke database (dalam bentuk angka 2 desimal)
                KpiRecord::create([
                    'user_id' => $user->id,
                    'kpimetrics_id' => $kpiMetric->id,
                    'simulasi_penambahan' => $simulasi,
                    'achievement' => number_format($achievement, 2), // contoh: 110.00
                    'score' => number_format($score, 2),             // contoh: 11.00
                ]);
            }
        }

        notify()->success('Berhasil Menghitung', 'Sukses');

        return redirect()->back();
    }

    public function laporan()
    {
        $user = Auth::user();

        // Ambil riwayat perhitungan KPI user yang login
        $records = KpiRecord::where('user_id', $user->id)
            ->with('kpiMetric')
            ->latest()
            ->get();

        return view('pages.laporan.index', compact('records', 'user'));
    }

    public function download()
    {
        $user = Auth::user();

        $records = KpiRecord::where('user_id', $user->id)
            ->with('kpiMetric')
            ->latest()
            ->get();

        // Buat spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'Nama KPI');
        $sheet->setCellValue('B1', 'Simulasi Penambahan');
        $sheet->setCellValue('C1', 'Target');
        $sheet->setCellValue('D1', 'Bobot');
        $sheet->setCellValue('E1', 'Achievement (%)');
        $sheet->setCellValue('F1', 'Weightages (%)');
        $sheet->setCellValue('G1', 'Score (%)');
        $sheet->setCellValue('H1', 'Tanggal');

        // Data
        $row = 2;
        foreach ($records as $record) {
            $sheet->setCellValue('A' . $row, $record->kpiMetric->nama_kpi);
            $sheet->setCellValue('B' . $row, $record->simulasi_penambahan);
            $sheet->setCellValue('C' . $row, $record->kpiMetric->target);
            $sheet->setCellValue('D' . $row, $record->kpiMetric->bobot);
            $sheet->setCellValue('E' . $row, $record->achievement . '%');
            $sheet->setCellValue('F' . $row, $record->kpiMetric->weightages . '%');
            $sheet->setCellValue('G' . $row, $record->score . '%');
            $sheet->setCellValue('H' . $row, $record->created_at->format('d-m-Y H:i'));
            $row++;
        }

        // Buat file download
        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_KPI_' . $user->name . '.xlsx';

        // Return sebagai response download
        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment;filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }
}

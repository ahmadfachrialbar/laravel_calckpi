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

        $jobKpis = $user->jobPosition?->kpiMetrics ?? collect();
        $userKpis = $user->kpiMetrics ?? collect();
        $kpis = $jobKpis->merge($userKpis);

        $records = KpiRecord::where('user_id', $user->id)
            ->with('kpiMetric')
            ->latest()
            ->get()
            ->groupBy('kpimetrics_id')
            ->map(fn($items) => $items->first());

        $totalScore = $records->sum('score');

        return view('pages.hitungkpi.index', compact('kpis', 'records', 'user', 'totalScore'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!is_array($request->kpi)) {
            return back()->withErrors(['error' => 'Format data KPI tidak valid.']);
        }

        foreach ($request->kpi as $item) {
            $kpiMetric = KpiMetrics::find($item['metric_id']);

            if (
                $kpiMetric &&
                (
                    $user->job_position_id == $kpiMetric->job_position_id ||
                    $user->kpiMetrics->contains('id', $kpiMetric->id)
                )
            ) {
                $simulasi = floatval($item['simulasi_penambahan']);
                $bobot = floatval($kpiMetric->bobot);
                $target = floatval($kpiMetric->target) ?: 1;
                $weightages = floatval($kpiMetric->weightages);
                $kategori = $kpiMetric->kategori;

                switch ($kategori) {
                    case 'up':
                        $achievement = (($bobot + $simulasi) / $target) * 100;
                        if ($achievement > 100) $achievement = 100;
                        break;
                    case 'down':
                        $achievement = (1 - ((($bobot + $simulasi) - $target) / $target)) * 100;
                        if ($achievement > 100) $achievement = 100;
                        break;
                    case 'zero':
                        $achievement = 100 - (($bobot + $simulasi) / 4) * 100;
                        if ($achievement > 100) $achievement = 100;
                        if ($achievement < 0) $achievement = 0;
                        break;
                    default:
                        $achievement = 0;
                }

                $score = ($achievement * $weightages) / 100;

                // Replace: hapus record lama sebelum simpan
                KpiRecord::where('user_id', $user->id)
                    ->where('kpimetrics_id', $kpiMetric->id)
                    ->delete();

                KpiRecord::create([
                    'user_id' => $user->id,
                    'kpimetrics_id' => $kpiMetric->id,
                    'simulasi_penambahan' => round($simulasi, 2),
                    'achievement' => round($achievement, 2),
                    'score' => round($score, 2),
                ]);
            }
        }

        notify()->success('Berhasil Menghitung', 'Sukses');
        return redirect()->back();
    }

    public function laporan()
    {
        $user = Auth::user();

        $records = KpiRecord::where('user_id', $user->id)
            ->with('kpiMetric')
            ->get()
            ->groupBy('kpimetrics_id')
            ->map(fn($items) => $items->sortByDesc('created_at')->first())
            ->values();

        $totalScore = $records->sum('score');

        return view('pages.laporan.index', compact('records', 'user', 'totalScore'));
    }

    public function laporanAdmin()
    {
        $karyawan = \App\Models\User::role('karyawan')
            ->with(['jobPosition', 'kpiRecords'])
            ->get()
            ->map(function ($user) {
                $latestRecords = $user->kpiRecords
                    ->groupBy('kpimetrics_id')
                    ->map(fn($items) => $items->sortByDesc('created_at')->first());

                $totalScore = $latestRecords->sum('score');

                if ($totalScore == 0) {
                    $indikator = 'Belum Hitung';
                } elseif ($totalScore < 60) {
                    $indikator = 'Buruk';
                } elseif ($totalScore <= 80) {
                    $indikator = 'Cukup';
                } else {
                    $indikator = 'Baik';
                }

                return (object) [
                    'id' => $user->id,
                    'nip' => $user->nip,
                    'name' => $user->name,
                    'job' => $user->jobPosition->name ?? '-',
                    'total_score' => $totalScore,
                    'indikator' => $indikator
                ];
            });

        return view('pages.laporan.admin', compact('karyawan'));
    }

    public function download()
    {
        $user = Auth::user();
        $records = KpiRecord::where('user_id', $user->id)
            ->with('kpiMetric')
            ->latest()
            ->get();

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

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_KPI_' . $user->name . '.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment;filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function downloadLaporanAdmin()
    {
        $karyawan = \App\Models\User::role('karyawan')
            ->with(['jobPosition', 'kpiRecords'])
            ->get()
            ->map(function ($user) {
                $totalScore = $user->kpiRecords
                    ->groupBy('kpimetrics_id')
                    ->map(fn($items) => $items->sortByDesc('created_at')->first())
                    ->sum('score');

                $indikator = $totalScore >= 75 ? 'Baik' : 'Buruk';

                return (object) [
                    'id' => $user->id,
                    'nip' => $user->nip,
                    'name' => $user->name,
                    'job' => $user->jobPosition->name ?? '-',
                    'total_score' => $totalScore,
                    'indikator' => $indikator
                ];
            });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray(['NIP', 'Nama', 'Jabatan/Dept', 'Total Score', 'Indikator'], null, 'A1');

        $row = 2;
        foreach ($karyawan as $data) {
            $sheet->fromArray([
                $data->nip,
                $data->name,
                $data->job,
                $data->total_score,
                $data->indikator
            ], null, 'A' . $row);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laporan_KPI_Admin.xlsx';

        return new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment;filename=\"$filename\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function showLaporanAdmin($id)
    {
        $user = \App\Models\User::with('jobPosition')->findOrFail($id);

        $records = \App\Models\KpiRecord::where('user_id', $user->id)
            ->with('kpiMetric')
            ->latest()
            ->get();

        // Hitung total score hanya dari record terbaru per KPI
        $latestRecords = $records->groupBy('kpimetrics_id')
            ->map(fn($items) => $items->sortByDesc('created_at')->first());

        $totalScore = $latestRecords->sum('score');

        return view('pages.laporan.show', compact('user', 'records', 'totalScore'));
    }
}

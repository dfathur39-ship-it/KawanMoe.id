<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $kelas = Kelas::where('is_active', true)->get();
        $years = range(Carbon::now()->year - 2, Carbon::now()->year + 1);
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create()->month($i)->translatedFormat('F');
        }

        return view('report.index', compact('kelas', 'years', 'months'));
    }

    public function downloadHarian(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $tanggal = Carbon::parse($request->tanggal);

        $siswaList = Siswa::where('kelas_id', $kelas->id)
            ->where('is_active', true)
            ->orderBy('nama_lengkap')
            ->get();

        $absensi = Absensi::where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        return $this->downloadPdf('report.pdf.harian', compact('kelas', 'tanggal', 'siswaList', 'absensi'),
            'Absensi_' . $kelas->nama_kelas . '_' . $tanggal->format('d-m-Y') . '.pdf');
    }

    public function downloadBulanan(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|digits:4',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;
        $daysInMonth = Carbon::create($tahun, $bulan)->daysInMonth;
        $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

        $siswaList = Siswa::where('kelas_id', $kelas->id)
            ->where('is_active', true)
            ->orderBy('nama_lengkap')
            ->get();

        $absensiData = [];
        foreach ($siswaList as $siswa) {
            $absensi = Absensi::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->get()
                ->keyBy(fn ($item) => $item->tanggal->day);

            $absensiData[$siswa->id] = [
                'siswa' => $siswa,
                'absensi' => $absensi,
                'summary' => [
                    'hadir' => $absensi->where('status', 'hadir')->count(),
                    'izin' => $absensi->where('status', 'izin')->count(),
                    'sakit' => $absensi->where('status', 'sakit')->count(),
                    'alpha' => $absensi->where('status', 'alpha')->count(),
                ],
            ];
        }

        return $this->downloadPdf('report.pdf.bulanan', compact(
            'kelas', 'bulan', 'tahun', 'namaBulan', 'daysInMonth', 'siswaList', 'absensiData'
        ), 'Absensi_' . $kelas->nama_kelas . '_' . $namaBulan . '_' . $tahun . '.pdf', 'a4', 'landscape');
    }

    public function downloadTahunan(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tahun' => 'required|digits:4',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $tahun = (int) $request->tahun;

        $siswaList = Siswa::where('kelas_id', $kelas->id)
            ->where('is_active', true)
            ->orderBy('nama_lengkap')
            ->get();

        $absensiData = [];
        foreach ($siswaList as $siswa) {
            $monthlyData = [];
            for ($month = 1; $month <= 12; $month++) {
                $absensi = Absensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', $month)
                    ->whereYear('tanggal', $tahun)
                    ->get();

                $monthlyData[$month] = [
                    'hadir' => $absensi->where('status', 'hadir')->count(),
                    'izin' => $absensi->where('status', 'izin')->count(),
                    'sakit' => $absensi->where('status', 'sakit')->count(),
                    'alpha' => $absensi->where('status', 'alpha')->count(),
                    'total' => $absensi->count(),
                ];
            }

            $yearlyTotal = Absensi::where('siswa_id', $siswa->id)
                ->whereYear('tanggal', $tahun)
                ->get();

            $absensiData[$siswa->id] = [
                'siswa' => $siswa,
                'monthly' => $monthlyData,
                'yearly' => [
                    'hadir' => $yearlyTotal->where('status', 'hadir')->count(),
                    'izin' => $yearlyTotal->where('status', 'izin')->count(),
                    'sakit' => $yearlyTotal->where('status', 'sakit')->count(),
                    'alpha' => $yearlyTotal->where('status', 'alpha')->count(),
                    'total' => $yearlyTotal->count(),
                ],
            ];
        }

        return $this->downloadPdf('report.pdf.tahunan', compact('kelas', 'tahun', 'siswaList', 'absensiData'),
            'Absensi_Tahunan_' . $kelas->nama_kelas . '_' . $tahun . '.pdf', 'a4', 'landscape');
    }

    protected function downloadPdf(string $view, array $data, string $filename, string $paper = 'a4', string $orientation = 'portrait')
    {
        if (! class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()->route('report.index')
                ->with('error', 'Silakan install package PDF: composer require barryvdh/laravel-dompdf');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($view, $data)->setPaper($paper, $orientation);
        return $pdf->download($filename);
    }
}

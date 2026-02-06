<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        if ($user->isSiswa()) {
            return $this->dashboardSiswa($user, $today, $currentMonth, $currentYear);
        }

        return $this->dashboardAdmin($today, $currentMonth, $currentYear);
    }

    protected function dashboardAdmin($today, $currentMonth, $currentYear)
    {
        $totalSiswa = Siswa::where('is_active', true)->count();
        $totalKelas = Kelas::where('is_active', true)->count();

        $absensiHariIni = Absensi::whereDate('tanggal', $today)->get();
        $statsHariIni = [
            'hadir' => $absensiHariIni->where('status', 'hadir')->count(),
            'izin' => $absensiHariIni->where('status', 'izin')->count(),
            'sakit' => $absensiHariIni->where('status', 'sakit')->count(),
            'alpha' => $absensiHariIni->where('status', 'alpha')->count(),
        ];

        $absensiBulanIni = Absensi::whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->get();
        $statsBulanIni = [
            'hadir' => $absensiBulanIni->where('status', 'hadir')->count(),
            'izin' => $absensiBulanIni->where('status', 'izin')->count(),
            'sakit' => $absensiBulanIni->where('status', 'sakit')->count(),
            'alpha' => $absensiBulanIni->where('status', 'alpha')->count(),
        ];

        $totalAbsensiBulanIni = $absensiBulanIni->count();
        $persentaseHadir = $totalAbsensiBulanIni > 0
            ? round(($statsBulanIni['hadir'] / $totalAbsensiBulanIni) * 100, 1)
            : 0;

        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $absensi = Absensi::whereDate('tanggal', $date)->get();
            $chartData[] = [
                'tanggal' => $date->format('d M'),
                'hadir' => $absensi->where('status', 'hadir')->count(),
                'izin' => $absensi->where('status', 'izin')->count(),
                'sakit' => $absensi->where('status', 'sakit')->count(),
                'alpha' => $absensi->where('status', 'alpha')->count(),
            ];
        }

        $kelasWithStats = Kelas::where('is_active', true)
            ->withCount('siswa')
            ->get()
            ->map(function ($kelas) use ($today) {
                $absensiHariIni = Absensi::where('kelas_id', $kelas->id)
                    ->whereDate('tanggal', $today)
                    ->get();
                $kelas->stats = [
                    'hadir' => $absensiHariIni->where('status', 'hadir')->count(),
                    'total' => $kelas->siswa_count,
                ];
                return $kelas;
            });

        $absensiTerbaru = Absensi::with(['siswa', 'kelas'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.admin', compact(
            'totalSiswa',
            'totalKelas',
            'statsHariIni',
            'statsBulanIni',
            'persentaseHadir',
            'chartData',
            'kelasWithStats',
            'absensiTerbaru',
            'today'
        ));
    }

    protected function dashboardSiswa($user, $today, $currentMonth, $currentYear)
    {
        $siswa = $user->siswa;
        if (! $siswa) {
            return view('dashboard.siswa', ['siswa' => null, 'statsHariIni' => [], 'statsBulanIni' => [], 'absensiTerbaru' => collect(), 'today' => $today]);
        }

        $statsHariIni = [];
        $absensiHariIni = Absensi::where('siswa_id', $siswa->id)->whereDate('tanggal', $today)->first();
        if ($absensiHariIni) {
            $statsHariIni = ['status' => $absensiHariIni->status, 'waktu_masuk' => $absensiHariIni->waktu_masuk];
        }

        $absensiBulanIni = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->get();
        $statsBulanIni = [
            'hadir' => $absensiBulanIni->where('status', 'hadir')->count(),
            'izin' => $absensiBulanIni->where('status', 'izin')->count(),
            'sakit' => $absensiBulanIni->where('status', 'sakit')->count(),
            'alpha' => $absensiBulanIni->where('status', 'alpha')->count(),
        ];

        $absensiTerbaru = Absensi::where('siswa_id', $siswa->id)
            ->with('kelas')
            ->orderBy('tanggal', 'desc')
            ->limit(15)
            ->get();

        return view('dashboard.siswa', compact('siswa', 'statsHariIni', 'statsBulanIni', 'absensiTerbaru', 'today'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::where('is_active', true)->get();
        $selectedKelas = $request->kelas_id;
        $selectedDate = $request->tanggal ?? Carbon::today()->format('Y-m-d');

        $absensi = collect();
        $siswaList = collect();

        if ($selectedKelas) {
            $siswaList = Siswa::where('kelas_id', $selectedKelas)
                ->where('is_active', true)
                ->orderBy('nama_lengkap')
                ->get();

            $absensi = Absensi::with('siswa')
                ->where('kelas_id', $selectedKelas)
                ->whereDate('tanggal', $selectedDate)
                ->get()
                ->keyBy('siswa_id');
        }

        return view('absensi.index', compact(
            'kelas',
            'selectedKelas',
            'selectedDate',
            'siswaList',
            'absensi'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required|exists:siswa,id',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $tanggal = $request->tanggal;
        $kelasId = $request->kelas_id;
        $waktuSekarang = Carbon::now()->format('H:i:s');

        foreach ($request->absensi as $data) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $data['siswa_id'],
                    'tanggal' => $tanggal,
                ],
                [
                    'kelas_id' => $kelasId,
                    'status' => $data['status'],
                    'waktu_masuk' => $data['status'] === 'hadir' ? $waktuSekarang : null,
                    'keterangan' => $data['keterangan'] ?? null,
                    'recorded_by' => Auth::id(),
                ]
            );
        }

        return redirect()->route('absensi.index', [
            'kelas_id' => $kelasId,
            'tanggal' => $tanggal,
        ])->with('success', 'Data absensi berhasil disimpan!');
    }

    public function quickAttendance(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);

        $siswa = Siswa::findOrFail($request->siswa_id);
        $today = Carbon::today();
        $waktuSekarang = Carbon::now()->format('H:i:s');

        $absensi = Absensi::updateOrCreate(
            [
                'siswa_id' => $siswa->id,
                'tanggal' => $today,
            ],
            [
                'kelas_id' => $siswa->kelas_id,
                'status' => $request->status,
                'waktu_masuk' => $request->status === 'hadir' ? $waktuSekarang : null,
                'recorded_by' => Auth::id(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil dicatat!',
            'data' => $absensi->load('siswa'),
        ]);
    }

    public function bulanan(Request $request)
    {
        $kelas = Kelas::where('is_active', true)->get();
        $selectedKelas = $request->kelas_id;
        $selectedMonth = $request->bulan ?? Carbon::now()->month;
        $selectedYear = $request->tahun ?? Carbon::now()->year;

        $siswaList = collect();
        $absensiData = [];
        $daysInMonth = Carbon::create($selectedYear, $selectedMonth)->daysInMonth;

        if ($selectedKelas) {
            $siswaList = Siswa::where('kelas_id', $selectedKelas)
                ->where('is_active', true)
                ->orderBy('nama_lengkap')
                ->get();

            foreach ($siswaList as $siswa) {
                $absensi = Absensi::where('siswa_id', $siswa->id)
                    ->whereMonth('tanggal', $selectedMonth)
                    ->whereYear('tanggal', $selectedYear)
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
        }

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create()->month($i)->translatedFormat('F');
        }
        $years = range(Carbon::now()->year - 2, Carbon::now()->year + 1);

        return view('absensi.bulanan', compact(
            'kelas',
            'selectedKelas',
            'selectedMonth',
            'selectedYear',
            'siswaList',
            'absensiData',
            'daysInMonth',
            'months',
            'years'
        ));
    }

    public function tahunan(Request $request)
    {
        $kelas = Kelas::where('is_active', true)->get();
        $selectedKelas = $request->kelas_id;
        $selectedYear = $request->tahun ?? Carbon::now()->year;

        $siswaList = collect();
        $absensiData = [];

        if ($selectedKelas) {
            $siswaList = Siswa::where('kelas_id', $selectedKelas)
                ->where('is_active', true)
                ->orderBy('nama_lengkap')
                ->get();

            foreach ($siswaList as $siswa) {
                $monthlyData = [];
                for ($month = 1; $month <= 12; $month++) {
                    $absensi = Absensi::where('siswa_id', $siswa->id)
                        ->whereMonth('tanggal', $month)
                        ->whereYear('tanggal', $selectedYear)
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
                    ->whereYear('tanggal', $selectedYear)
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
        }

        $years = range(Carbon::now()->year - 2, Carbon::now()->year + 1);

        return view('absensi.tahunan', compact(
            'kelas',
            'selectedKelas',
            'selectedYear',
            'siswaList',
            'absensiData',
            'years'
        ));
    }
}

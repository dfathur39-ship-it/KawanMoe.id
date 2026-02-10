<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class QrAbsenController extends Controller
{
    /**
     * Admin: tampilkan halaman untuk generate & tampilkan QR code absen.
     */
    public function showQr(Request $request)
    {
        $token = Str::random(32);
        $expiresAt = now()->addSeconds(3);
        Cache::put('qrabsen_' . $token, [
            'created_at' => now()->toDateTimeString(),
            'expires_at' => $expiresAt->toDateTimeString(),
        ], $expiresAt);

        $scanUrl = route('absen.scan', ['token' => $token]);

        return view('qrabsen.show', compact('token', 'scanUrl', 'expiresAt'));
    }

    /**
     * API: generate token & URL QR baru (untuk auto-refresh setiap 3 detik).
     */
    public function refreshQr(Request $request)
    {
        $token = Str::random(32);
        $expiresAt = now()->addSeconds(3);
        Cache::put('qrabsen_' . $token, [
            'created_at' => now()->toDateTimeString(),
            'expires_at' => $expiresAt->toDateTimeString(),
        ], $expiresAt);

        $scanUrl = route('absen.scan', ['token' => $token]);

        return response()->json([
            'scanUrl' => $scanUrl,
            'expiresAt' => $expiresAt->timestamp,
        ]);
    }

    /**
     * Halaman untuk siswa scan QR (bisa dibuka dari HP setelah scan).
     * URL dari QR: /absen/scan/{token}
     */
    public function scanPage(Request $request, string $token)
    {
        $cached = Cache::get('qrabsen_' . $token);
        if (! $cached) {
            return redirect()->route('login')->with('error', 'Kode QR sudah tidak valid atau kedaluwarsa.');
        }

        if (! Auth::check()) {
            session(['url.intended' => route('absen.scan', ['token' => $token])]);
            return redirect()->route('login')->with('info', 'Silakan login terlebih dahulu untuk absen.');
        }

        $user = Auth::user();
        if (! $user->isSiswa() || ! $user->siswa_id) {
            return redirect()->route('dashboard')->with('error', 'Hanya siswa yang dapat absen via QR.');
        }

        $today = Carbon::today();
        $existing = Absensi::where('siswa_id', $user->siswa_id)->whereDate('tanggal', $today)->first();
        if ($existing) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah melakukan absen hari ini (' . $existing->status . ').');
        }

        Absensi::create([
            'siswa_id' => $user->siswa_id,
            'kelas_id' => $user->siswa->kelas_id,
            'tanggal' => $today,
            'waktu_masuk' => now()->format('H:i:s'),
            'status' => 'hadir',
            'recorded_by' => $user->id,
        ]);

        Cache::forget('qrabsen_' . $token);

        return redirect()->route('dashboard')->with('success', 'Absensi berhasil dicatat. Selamat datang!');
    }

    /**
     * API/redirect: validasi token dan catat absensi (untuk siswa yang sudah login).
     */
    public function submitScan(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        $token = $request->token;
        $cached = Cache::get('qrabsen_' . $token);
        if (! $cached) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kode QR tidak valid atau kedaluwarsa.'], 400);
            }
            return redirect()->route('dashboard')->with('error', 'Kode QR tidak valid atau kedaluwarsa.');
        }

        $user = Auth::user();
        if (! $user->isSiswa() || ! $user->siswa_id) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Hanya siswa yang dapat absen.'], 403);
            }
            return redirect()->route('dashboard')->with('error', 'Hanya siswa yang dapat absen via QR.');
        }

        $today = Carbon::today();
        $existing = Absensi::where('siswa_id', $user->siswa_id)->whereDate('tanggal', $today)->first();
        if ($existing) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda sudah absen hari ini.']);
            }
            return redirect()->route('dashboard')->with('info', 'Anda sudah absen hari ini.');
        }

        Absensi::create([
            'siswa_id' => $user->siswa_id,
            'kelas_id' => $user->siswa->kelas_id,
            'tanggal' => $today,
            'waktu_masuk' => now()->format('H:i:s'),
            'status' => 'hadir',
            'recorded_by' => $user->id,
        ]);

        Cache::forget('qrabsen_' . $token);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Absensi berhasil dicatat.']);
        }
        return redirect()->route('dashboard')->with('success', 'Absensi berhasil dicatat.');
    }
}

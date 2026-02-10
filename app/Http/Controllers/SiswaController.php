<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with('kelas');

        if ($request->kelas_id) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                    ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        $siswa = $query->orderBy('nama_lengkap')->paginate(15);
        $kelas = Kelas::where('is_active', true)->get();

        return view('siswa.index', compact('siswa', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::where('is_active', true)->get();
        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nis' => 'required|unique:siswa,nis',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'foto' => 'nullable|image|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
            $rules['email'] = 'required|email|unique:users,email';
        }

        $request->validate($rules);

        $data = $request->except(['foto', 'password', 'password_confirmation']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa = Siswa::create($data);

        if ($request->filled('password') && $request->email) {
            User::create([
                'name' => $siswa->nama_lengkap,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'siswa',
                'siswa_id' => $siswa->id,
                'kelas_id' => $siswa->kelas_id,
            ]);
        }

        $msg = 'Siswa berhasil ditambahkan!';
        if ($request->filled('password')) {
            $msg = 'Siswa dan akun login berhasil ditambahkan!';
        }
        return redirect()->route('siswa.index')->with('success', $msg);
    }

    public function edit(Siswa $siswa)
    {
        $siswa->load('user');
        $kelas = Kelas::where('is_active', true)->get();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $rules = [
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'foto' => 'nullable|image|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Password::min(8)];
        }

        $request->validate($rules);

        $data = $request->except(['foto', 'password', 'password_confirmation']);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $data['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($data);

        if ($request->filled('password')) {
            $user = $siswa->user;
            $email = $request->email ?: $siswa->email;
            if ($user) {
                $user->update([
                    'password' => $request->password,
                    'name' => $siswa->nama_lengkap,
                    'email' => $email ?: $user->email,
                ]);
            } else {
                if (empty($email)) {
                    return back()->withErrors(['email' => 'Email wajib diisi untuk membuat akun login siswa.'])->withInput();
                }
                if (User::where('email', $email)->exists()) {
                    return back()->withErrors(['email' => 'Email ini sudah dipakai akun lain.'])->withInput();
                }
                User::create([
                    'name' => $siswa->nama_lengkap,
                    'email' => $email,
                    'password' => $request->password,
                    'role' => 'siswa',
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $siswa->kelas_id,
                ]);
            }
        }

        $msg = 'Data siswa berhasil diupdate!';
        if ($request->filled('password')) {
            $msg = 'Data siswa dan password berhasil diupdate!';
        }
        return redirect()->route('siswa.index')->with('success', $msg);
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load(['kelas', 'absensi' => fn ($q) => $q->orderBy('tanggal', 'desc')->limit(30)]);
        return view('siswa.show', compact('siswa'));
    }
}

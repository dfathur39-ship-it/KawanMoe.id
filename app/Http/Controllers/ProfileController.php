<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        $kelas = Kelas::where('is_active', true)->get();

        return view('profile.show', compact('user', 'siswa', 'kelas'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ];

        if ($user->isSiswa() && $user->siswa) {
            $rules['no_telepon'] = 'nullable|string|max:20';
            $rules['alamat'] = 'nullable|string';
        }

        if ($request->filled('password')) {
            $rules['password'] = ['nullable', 'confirmed', Password::min(8)];
        }

        $data = $request->validate($rules);

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        if ($user->isSiswa() && $user->siswa) {
            $user->siswa->update([
                'no_telepon' => $request->no_telepon,
                'alamat' => $request->alamat,
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}

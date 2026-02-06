<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('siswa')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:50',
            'jurusan' => 'nullable|string|max:255',
            'wali_kelas' => 'nullable|string|max:255',
            'tahun_ajaran' => 'required|digits:4',
        ]);

        Kelas::create(array_merge($request->only(['nama_kelas', 'tingkat', 'jurusan', 'wali_kelas', 'tahun_ajaran']), ['is_active' => $request->boolean('is_active', true)]));

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function edit(Kelas $kelas)
    {
        return view('kelas.edit', compact('kelas'));
    }

    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:50',
            'jurusan' => 'nullable|string|max:255',
            'wali_kelas' => 'nullable|string|max:255',
            'tahun_ajaran' => 'required|digits:4',
        ]);

        $kelas->update(array_merge($request->only(['nama_kelas', 'tingkat', 'jurusan', 'wali_kelas', 'tahun_ajaran']), ['is_active' => $request->boolean('is_active', true)]));

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diupdate!');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }

    public function show(Kelas $kelas)
    {
        $kelas->load('siswa');
        return view('kelas.show', compact('kelas'));
    }
}

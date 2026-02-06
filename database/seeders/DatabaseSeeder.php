<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin (hanya bisa login, tidak bisa register)
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@absensi.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Kelas contoh
        $kelasData = [
            ['nama_kelas' => 'A', 'tingkat' => 'X', 'jurusan' => 'IPA', 'wali_kelas' => 'Budi Santoso, S.Pd', 'tahun_ajaran' => 2024],
            ['nama_kelas' => 'B', 'tingkat' => 'X', 'jurusan' => 'IPA', 'wali_kelas' => 'Siti Aminah, S.Pd', 'tahun_ajaran' => 2024],
            ['nama_kelas' => 'A', 'tingkat' => 'XI', 'jurusan' => 'IPA', 'wali_kelas' => 'Ahmad Yani, S.Pd', 'tahun_ajaran' => 2024],
        ];

        foreach ($kelasData as $k) {
            Kelas::create($k);
        }

        // Siswa contoh (NIS untuk register siswa)
        $namaLaki = ['Ahmad', 'Budi', 'Cahyo', 'Dani', 'Eko'];
        $namaPerempuan = ['Anisa', 'Bella', 'Citra', 'Dina', 'Eka'];
        $namaBelakang = ['Pratama', 'Saputra', 'Wijaya', 'Kusuma', 'Santoso'];

        $siswaId = 1;
        foreach (Kelas::all() as $kelas) {
            for ($i = 0; $i < 5; $i++) {
                $isLaki = $i < 3;
                $namaDepan = $isLaki ? $namaLaki[array_rand($namaLaki)] : $namaPerempuan[array_rand($namaPerempuan)];
                $nama = $namaDepan . ' ' . $namaBelakang[array_rand($namaBelakang)];

                Siswa::create([
                    'nis' => '2024' . str_pad($siswaId, 4, '0', STR_PAD_LEFT),
                    'nama_lengkap' => $nama,
                    'jenis_kelamin' => $isLaki ? 'L' : 'P',
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => Carbon::now()->subYears(rand(15, 17)),
                    'alamat' => 'Jl. Contoh No. ' . rand(1, 50),
                    'no_telepon' => '08' . rand(100000000, 999999999),
                    'kelas_id' => $kelas->id,
                    'is_active' => true,
                ]);
                $siswaId++;
            }
        }

        $this->command->info('Database seeded!');
        $this->command->info('Admin login: admin@absensi.test / password');
        $this->command->info('Siswa dapat register dengan NIS (contoh: 20240001) lalu login.');
    }
}

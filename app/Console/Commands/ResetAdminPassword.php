<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password {email?} {--password=}';
    protected $description = 'Reset password admin atau buat admin baru';

    public function handle()
    {
        $email = $this->argument('email') ?? $this->ask('Masukkan email admin');
        $password = $this->option('password') ?? $this->secret('Masukkan password baru (min 8 karakter)');

        if (strlen($password) < 8) {
            $this->error('Password minimal 8 karakter!');
            return 1;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            // Update password existing user
            $user->password = Hash::make($password);
            $user->save();
            $this->info("✅ Password untuk {$email} berhasil direset!");
        } else {
            // Buat admin baru
            $name = $this->ask('Nama admin (default: Administrator)', 'Administrator');
            $role = $this->choice('Role', ['admin', 'siswa'], 0);
            
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
            ]);
            $this->info("✅ Admin baru berhasil dibuat!");
        }

        $this->line("Email: {$email}");
        $this->line("Password: {$password}");
        $this->warn("⚠️  Simpan kredensial ini dengan aman!");

        return 0;
    }
}

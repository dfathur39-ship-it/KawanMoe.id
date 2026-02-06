<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {email} {password} {--name=Administrator}';
    protected $description = 'Buat user admin baru';

    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $name = $this->option('name');

        if (User::where('email', $email)->exists()) {
            $this->error("Email {$email} sudah terdaftar!");
            return 1;
        }

        if (strlen($password) < 8) {
            $this->error('Password minimal 8 karakter!');
            return 1;
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info("✅ Admin berhasil dibuat!");
        $this->line("Email: {$email}");
        $this->line("Password: {$password}");
        $this->warn("⚠️  Simpan kredensial ini dengan aman!");

        return 0;
    }
}

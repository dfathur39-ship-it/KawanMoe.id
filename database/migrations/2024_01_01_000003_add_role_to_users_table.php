<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'siswa'])->default('siswa')->after('email');
            $table->string('avatar')->nullable()->after('role');
            $table->foreignId('kelas_id')->nullable()->after('avatar')->constrained('kelas')->onDelete('set null');
            $table->foreignId('siswa_id')->nullable()->after('kelas_id')->constrained('siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['siswa_id']);
            $table->dropColumn(['role', 'avatar', 'kelas_id', 'siswa_id']);
        });
    }
};

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat',
        'jurusan',
        'wali_kelas',
        'tahun_ajaran',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function getFullNameAttribute()
    {
        return $this->tingkat . ' ' . $this->nama_kelas . ($this->jurusan ? ' - ' . $this->jurusan : '');
    }
}

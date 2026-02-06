<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'nis',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_telepon',
        'email',
        'foto',
        'kelas_id',
        'is_active',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_active' => 'boolean',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function getAbsensiByMonth($month, $year)
    {
        return $this->absensi()
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();
    }

    public function getAbsensiByYear($year)
    {
        return $this->absensi()
            ->whereYear('tanggal', $year)
            ->get();
    }
}

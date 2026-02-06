<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tanggal',
        'waktu_masuk',
        'waktu_pulang',
        'status',
        'keterangan',
        'recorded_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'hadir' => '<span class="badge bg-success">Hadir</span>',
            'izin' => '<span class="badge bg-warning">Izin</span>',
            'sakit' => '<span class="badge bg-info">Sakit</span>',
            'alpha' => '<span class="badge bg-danger">Alpha</span>',
            default => '<span class="badge bg-secondary">-</span>',
        };
    }

    public static function getStatsByKelas($kelasId, $month = null, $year = null)
    {
        $query = self::where('kelas_id', $kelasId);

        if ($month) {
            $query->whereMonth('tanggal', $month);
        }
        if ($year) {
            $query->whereYear('tanggal', $year);
        }

        return [
            'hadir' => (clone $query)->where('status', 'hadir')->count(),
            'izin' => (clone $query)->where('status', 'izin')->count(),
            'sakit' => (clone $query)->where('status', 'sakit')->count(),
            'alpha' => (clone $query)->where('status', 'alpha')->count(),
            'total' => $query->count(),
        ];
    }
}

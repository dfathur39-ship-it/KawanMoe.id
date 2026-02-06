@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                @if($siswa->foto)
                    <img src="{{ Storage::url($siswa->foto) }}" class="rounded-circle mb-3" width="120" height="120" style="object-fit:cover;">
                @else
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width:120px;height:120px;font-size:2.5rem;">{{ strtoupper(substr($siswa->nama_lengkap, 0, 2)) }}</div>
                @endif
                <h4 class="mb-1">{{ $siswa->nama_lengkap }}</h4>
                <p class="text-muted mb-2">NIS: {{ $siswa->nis }}</p>
                <span class="badge {{ $siswa->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-danger' }} mb-2">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                <br>
                <span class="badge {{ $siswa->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $siswa->is_active ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
            <div class="card-body border-top">
                <div class="mb-3"><small class="text-muted d-block">Kelas</small><strong>{{ $siswa->kelas->tingkat ?? '-' }} {{ $siswa->kelas->nama_kelas ?? '' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Tempat, Tanggal Lahir</small><strong>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">No. Telepon</small><strong>{{ $siswa->no_telepon ?? '-' }}</strong></div>
                <div class="mb-3"><small class="text-muted d-block">Email</small><strong>{{ $siswa->email ?? '-' }}</strong></div>
                <div><small class="text-muted d-block">Alamat</small><strong>{{ $siswa->alamat ?? '-' }}</strong></div>
            </div>
            <div class="card-body border-top">
                <div class="d-flex gap-2">
                    <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-warning flex-fill"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary flex-fill"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Riwayat Absensi (30 Hari Terakhir)</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>Tanggal</th><th>Waktu Masuk</th><th>Status</th><th>Keterangan</th></tr></thead>
                        <tbody>
                            @forelse($siswa->absensi as $absen)
                                <tr>
                                    <td>{{ $absen->tanggal->format('d/m/Y') }}</td>
                                    <td>{{ $absen->waktu_masuk ?? '-' }}</td>
                                    <td>{!! $absen->status_badge !!}</td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada riwayat absensi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

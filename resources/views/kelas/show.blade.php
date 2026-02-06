@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="stat-icon primary mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;"><i class="bi bi-building"></i></div>
                <h4>{{ $kelas->tingkat }} {{ $kelas->nama_kelas }}</h4>
                @if($kelas->jurusan)<p class="text-muted">{{ $kelas->jurusan }}</p>@endif
                <span class="badge {{ $kelas->is_active ? 'bg-success' : 'bg-secondary' }} mb-3">{{ $kelas->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                <div class="border-top pt-3 mt-3">
                    <div class="row text-start">
                        <div class="col-6 mb-3"><small class="text-muted d-block">Tahun Ajaran</small><strong>{{ $kelas->tahun_ajaran }}/{{ $kelas->tahun_ajaran + 1 }}</strong></div>
                        <div class="col-6 mb-3"><small class="text-muted d-block">Jumlah Siswa</small><strong>{{ $kelas->siswa->count() }} Siswa</strong></div>
                        @if($kelas->wali_kelas)<div class="col-12"><small class="text-muted d-block">Wali Kelas</small><strong>{{ $kelas->wali_kelas }}</strong></div>@endif
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('kelas.edit', $kelas) }}" class="btn btn-warning flex-fill"><i class="bi bi-pencil me-1"></i>Edit</a>
                    <a href="{{ route('kelas.index') }}" class="btn btn-secondary flex-fill"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people me-2 text-primary"></i>Daftar Siswa</h5>
                <a href="{{ route('siswa.create') }}?kelas_id={{ $kelas->id }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg me-1"></i>Tambah Siswa</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th>No</th><th>NIS</th><th>Nama</th><th>L/P</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse($kelas->siswa as $index => $siswa)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $siswa->nis }}</td>
                                    <td>{{ $siswa->nama_lengkap }}</td>
                                    <td><span class="badge {{ $siswa->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-danger' }}">{{ $siswa->jenis_kelamin }}</span></td>
                                    <td><a href="{{ route('siswa.show', $siswa) }}" class="btn btn-sm btn-light"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada siswa di kelas ini</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

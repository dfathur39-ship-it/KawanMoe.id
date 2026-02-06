@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Manajemen Kelas</h4>
        <p class="text-muted mb-0">Kelola data kelas sekolah</p>
    </div>
    <a href="{{ route('kelas.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Kelas</a>
</div>

<div class="row g-4">
    @forelse($kelas as $k)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 position-relative">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon primary" style="width: 50px; height: 50px; font-size: 1.2rem;"><i class="bi bi-building"></i></div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm" type="button" data-bs-toggle="dropdown"><i class="bi bi-three-dots-vertical"></i></button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('kelas.show', $k) }}"><i class="bi bi-eye me-2"></i>Lihat Detail</a></li>
                            <li><a class="dropdown-item" href="{{ route('kelas.edit', $k) }}"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('kelas.destroy', $k) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <h5 class="card-title mb-1">{{ $k->tingkat }} {{ $k->nama_kelas }}</h5>
                @if($k->jurusan)<p class="text-muted mb-2">{{ $k->jurusan }}</p>@endif
                <div class="d-flex gap-3 mb-3">
                    <div><small class="text-muted d-block">Siswa</small><strong class="text-primary">{{ $k->siswa_count }}</strong></div>
                    <div><small class="text-muted d-block">Tahun Ajaran</small><strong>{{ $k->tahun_ajaran }}/{{ $k->tahun_ajaran + 1 }}</strong></div>
                </div>
                @if($k->wali_kelas)
                <div class="d-flex align-items-center gap-2 pt-3 border-top">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-person text-muted"></i></div>
                    <div><small class="text-muted d-block">Wali Kelas</small><strong style="font-size: 0.9rem;">{{ $k->wali_kelas }}</strong></div>
                </div>
                @endif
                <span class="badge {{ $k->is_active ? 'bg-success' : 'bg-secondary' }}" style="position:absolute;top:15px;right:55px;">{{ $k->is_active ? 'Aktif' : 'Nonaktif' }}</span>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-building fs-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Belum ada data kelas</h5>
                <a href="{{ route('kelas.create') }}" class="btn btn-primary mt-2"><i class="bi bi-plus-lg me-2"></i>Tambah Kelas Pertama</a>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection

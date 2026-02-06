@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Manajemen Siswa</h4>
        <p class="text-muted mb-0">Total {{ $siswa->total() }} siswa terdaftar</p>
    </div>
    <a href="{{ route('siswa.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Tambah Siswa</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('siswa.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Cari Siswa</label>
                <input type="text" name="search" class="form-control" placeholder="Nama atau NIS..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Filter Kelas</label>
                <select name="kelas_id" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->tingkat }} {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Cari</button></div>
            <div class="col-md-2"><a href="{{ route('siswa.index') }}" class="btn btn-secondary w-100"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</a></div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="100">NIS</th>
                        <th>Nama Lengkap</th>
                        <th width="60">L/P</th>
                        <th>Kelas</th>
                        <th>No. Telepon</th>
                        <th width="100">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                        <tr>
                            <td>{{ $siswa->firstItem() + $index }}</td>
                            <td><strong>{{ $s->nis }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($s->foto)
                                        <img src="{{ Storage::url($s->foto) }}" class="rounded-circle" width="35" height="35" style="object-fit:cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:35px;height:35px;font-size:0.8rem;">{{ strtoupper(substr($s->nama_lengkap, 0, 2)) }}</div>
                                    @endif
                                    {{ $s->nama_lengkap }}
                                </div>
                            </td>
                            <td><span class="badge {{ $s->jenis_kelamin == 'L' ? 'bg-primary' : 'bg-danger' }}">{{ $s->jenis_kelamin }}</span></td>
                            <td>{{ $s->kelas->tingkat ?? '-' }} {{ $s->kelas->nama_kelas ?? '' }}</td>
                            <td>{{ $s->no_telepon ?? '-' }}</td>
                            <td><span class="badge {{ $s->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $s->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('siswa.show', $s) }}" class="btn btn-light" title="Detail"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('siswa.edit', $s) }}" class="btn btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('siswa.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-light text-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-5"><i class="bi bi-inbox fs-1 d-block mb-2"></i>Tidak ada data siswa</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($siswa->hasPages())<div class="card-footer">{{ $siswa->links() }}</div>@endif
</div>
@endsection

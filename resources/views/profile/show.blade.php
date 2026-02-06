@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-person-fill me-2"></i>Data Profil</h5></div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    @if($user->isSiswa() && $siswa)
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" class="form-control" value="{{ $siswa->nis }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $siswa->no_telepon) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $siswa->alamat) }}</textarea>
                        </div>
                    @endif
                    <hr>
                    <h6 class="mb-3">Ubah Password (kosongkan jika tidak ingin mengubah)</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    @error('password')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-2"></i>Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="user-avatar mx-auto mb-3" style="width:80px;height:80px;font-size:2rem;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-0">{{ ucfirst($user->role) }}</p>
                @if($user->isSiswa() && $siswa)
                    <hr>
                    <p class="mb-1"><strong>NIS:</strong> {{ $siswa->nis }}</p>
                    <p class="mb-0"><strong>Kelas:</strong> {{ $siswa->kelas->tingkat ?? '' }} {{ $siswa->kelas->nama_kelas ?? '' }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

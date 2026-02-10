@extends('layouts.app')

@section('title', 'Edit Siswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Data Siswa</h5></div>
            <div class="card-body">
                <form action="{{ route('siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h6 class="mb-3 text-primary">Data Utama</h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">NIS <span class="text-danger">*</span></label>
                                <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $siswa->nis) }}" required>
                                @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}" required>
                                @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
                                    <select name="kelas_id" class="form-select" required>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->tingkat }} {{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $siswa->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label">Siswa Aktif</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3 text-primary">Data Kontak</h6>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">No. Telepon</label>
                                <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $siswa->no_telepon) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $siswa->email) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $siswa->alamat) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Foto</label>
                                <input type="file" name="foto" class="form-control" accept="image/*">
                                @if($siswa->foto)<small class="text-muted">Foto saat ini: {{ basename($siswa->foto) }}</small>@endif
                                @error('foto')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <h6 class="mb-3 text-info mt-3">Akun Login (opsional)</h6>
                            @if($siswa->user)
                                <p class="small text-muted mb-2">Siswa ini sudah punya akun. Isi password baru untuk mengubah, atau kosongkan jika tidak mengubah.</p>
                            @else
                                <p class="small text-muted mb-2">Siswa ini belum punya akun login. Isi password di bawah untuk membuat akun (gunakan email di atas).</p>
                            @endif
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password {{ $siswa->user ? 'baru' : '' }}</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" placeholder="Min. 8 karakter (kosongkan jika tidak mengubah)" autocomplete="new-password">
                                    <button type="button" class="input-group-text btn-password-toggle" tabindex="-1" aria-label="Tampilkan password" title="Tampilkan / sembunyikan password"><i class="bi bi-eye"></i></button>
                                </div>
                                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" autocomplete="new-password">
                                    <button type="button" class="input-group-text btn-password-toggle" tabindex="-1" aria-label="Tampilkan password" title="Tampilkan / sembunyikan password"><i class="bi bi-eye"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-warning"><i class="bi bi-save me-2"></i>Update</button>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

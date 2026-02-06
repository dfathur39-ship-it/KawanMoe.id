@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Kelas Baru</h5></div>
            <div class="card-body">
                <form action="{{ route('kelas.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="Contoh: A, B" value="{{ old('nama_kelas') }}" required>
                            @error('nama_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tingkat <span class="text-danger">*</span></label>
                            <select name="tingkat" class="form-select @error('tingkat') is-invalid @enderror" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X" {{ old('tingkat') == 'X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ old('tingkat') == 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ old('tingkat') == 'XII' ? 'selected' : '' }}>XII</option>
                                <option value="VII" {{ old('tingkat') == 'VII' ? 'selected' : '' }}>VII</option>
                                <option value="VIII" {{ old('tingkat') == 'VIII' ? 'selected' : '' }}>VIII</option>
                                <option value="IX" {{ old('tingkat') == 'IX' ? 'selected' : '' }}>IX</option>
                            </select>
                            @error('tingkat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" placeholder="IPA, IPS, dll" value="{{ old('jurusan') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran" class="form-select" required>
                                @for($year = date('Y') + 1; $year >= date('Y') - 2; $year--)
                                    <option value="{{ $year }}" {{ old('tahun_ajaran', date('Y')) == $year ? 'selected' : '' }}>{{ $year }}/{{ $year + 1 }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Wali Kelas</label>
                            <input type="text" name="wali_kelas" class="form-control" placeholder="Nama wali kelas" value="{{ old('wali_kelas') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="is_active">Kelas Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan</button>
                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

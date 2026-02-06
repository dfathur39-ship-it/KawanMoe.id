@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Kelas</h5></div>
            <div class="card-body">
                <form action="{{ route('kelas.update', $kelas) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                            @error('nama_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tingkat <span class="text-danger">*</span></label>
                            <select name="tingkat" class="form-select" required>
                                <option value="X" {{ old('tingkat', $kelas->tingkat) == 'X' ? 'selected' : '' }}>X</option>
                                <option value="XI" {{ old('tingkat', $kelas->tingkat) == 'XI' ? 'selected' : '' }}>XI</option>
                                <option value="XII" {{ old('tingkat', $kelas->tingkat) == 'XII' ? 'selected' : '' }}>XII</option>
                                <option value="VII" {{ old('tingkat', $kelas->tingkat) == 'VII' ? 'selected' : '' }}>VII</option>
                                <option value="VIII" {{ old('tingkat', $kelas->tingkat) == 'VIII' ? 'selected' : '' }}>VIII</option>
                                <option value="IX" {{ old('tingkat', $kelas->tingkat) == 'IX' ? 'selected' : '' }}>IX</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" value="{{ old('jurusan', $kelas->jurusan) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tahun Ajaran <span class="text-danger">*</span></label>
                            <select name="tahun_ajaran" class="form-select" required>
                                @for($year = date('Y') + 1; $year >= date('Y') - 2; $year--)
                                    <option value="{{ $year }}" {{ old('tahun_ajaran', $kelas->tahun_ajaran) == $year ? 'selected' : '' }}>{{ $year }}/{{ $year + 1 }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Wali Kelas</label>
                            <input type="text" name="wali_kelas" class="form-control" value="{{ old('wali_kelas', $kelas->wali_kelas) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $kelas->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label ms-2">Kelas Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-warning"><i class="bi bi-save me-2"></i>Update</button>
                        <a href="{{ route('kelas.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

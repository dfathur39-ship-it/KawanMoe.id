@extends('layouts.app')

@section('title', 'Absensi Harian')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('absensi.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Pilih Kelas</label>
                <select name="kelas_id" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>{{ $k->tingkat }} {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $selectedDate }}" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-2"></i>Tampilkan</button>
            </div>
        </form>
    </div>
</div>

@if($selectedKelas && $siswaList->isNotEmpty())
<form action="{{ route('absensi.store') }}" method="POST">
    @csrf
    <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
    <input type="hidden" name="tanggal" value="{{ $selectedDate }}">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Input Absensi - {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l, d F Y') }}</h5>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan Absensi</button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th width="120">Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswaList as $index => $s)
                            @php $absen = $absensi->get($s->id); @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->nis }}</td>
                                <td>{{ $s->nama_lengkap }}</td>
                                <td>
                                    <input type="hidden" name="absensi[{{ $index }}][siswa_id]" value="{{ $s->id }}">
                                    <select name="absensi[{{ $index }}][status]" class="form-select form-select-sm" required>
                                        <option value="hadir" {{ ($absen && $absen->status == 'hadir') ? 'selected' : '' }}>Hadir</option>
                                        <option value="izin" {{ ($absen && $absen->status == 'izin') ? 'selected' : '' }}>Izin</option>
                                        <option value="sakit" {{ ($absen && $absen->status == 'sakit') ? 'selected' : '' }}>Sakit</option>
                                        <option value="alpha" {{ ($absen && $absen->status == 'alpha') ? 'selected' : (!$absen ? 'selected' : '') }}>Alpha</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="absensi[{{ $index }}][keterangan]" class="form-control form-control-sm" placeholder="Opsional" value="{{ $absen->keterangan ?? '' }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>
@elseif($selectedKelas)
<div class="card">
    <div class="card-body text-center py-5 text-muted">
        <i class="bi bi-people fs-1 d-block mb-2"></i>
        Tidak ada siswa di kelas ini atau kelas belum dipilih.
    </div>
</div>
@endif
@endsection

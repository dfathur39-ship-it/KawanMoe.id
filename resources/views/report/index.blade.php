@extends('layouts.app')

@section('title', 'Download Laporan')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="text-center mb-4">
            <h4>Download Laporan Absensi</h4>
            <p class="text-muted">Pilih jenis laporan yang ingin diunduh dalam format PDF</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="stat-icon info mx-auto mb-3" style="width: 70px; height: 70px; font-size: 1.8rem;"><i class="bi bi-calendar-day"></i></div>
                <h5>Laporan Harian</h5>
                <p class="text-muted mb-4">Download rekap absensi per hari</p>
                <form action="{{ route('report.download.harian') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="kelas_id" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->tingkat }} {{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <button type="submit" class="btn btn-info w-100"><i class="bi bi-download me-2"></i>Download PDF</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="stat-icon warning mx-auto mb-3" style="width: 70px; height: 70px; font-size: 1.8rem;"><i class="bi bi-calendar-month"></i></div>
                <h5>Laporan Bulanan</h5>
                <p class="text-muted mb-4">Download rekap absensi per bulan</p>
                <form action="{{ route('report.download.bulanan') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="kelas_id" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->tingkat }} {{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-7">
                            <select name="bulan" class="form-select" required>
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ date('n') == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <select name="tahun" class="form-select" required>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning w-100"><i class="bi bi-download me-2"></i>Download PDF</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="stat-icon danger mx-auto mb-3" style="width: 70px; height: 70px; font-size: 1.8rem;"><i class="bi bi-calendar-range"></i></div>
                <h5>Laporan Tahunan</h5>
                <p class="text-muted mb-4">Download rekap absensi per tahun</p>
                <form action="{{ route('report.download.tahunan') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="kelas_id" class="form-select" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->tingkat }} {{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <select name="tahun" class="form-select" required>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-danger w-100"><i class="bi bi-download me-2"></i>Download PDF</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Rekap Absensi Tahunan')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('absensi.tahunan') }}" method="GET" class="row g-3 align-items-end">
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
                        <label class="form-label fw-semibold">Tahun</label>
                        <select name="tahun" class="form-select">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-2"></i>Tampilkan</button>
                    </div>
                    @if($selectedKelas)
                    <div class="col-md-2">
                        <form action="{{ route('report.download.tahunan') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $selectedKelas }}">
                            <input type="hidden" name="tahun" value="{{ $selectedYear }}">
                            <button type="submit" class="btn btn-danger w-100"><i class="bi bi-file-pdf me-2"></i>Download PDF</button>
                        </form>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    @if($selectedKelas && count($absensiData) > 0)
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calendar-range me-2 text-primary"></i>Rekap Absensi Tahun {{ $selectedYear }}</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0" style="font-size: 0.8rem;">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle">No</th>
                                <th rowspan="2" class="align-middle">Nama Siswa</th>
                                @php $bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']; @endphp
                                @foreach($bulanNames as $b)
                                    <th colspan="4" class="text-center">{{ $b }}</th>
                                @endforeach
                                <th colspan="4" class="text-center bg-primary text-white">Total</th>
                            </tr>
                            <tr>
                                @for($i = 0; $i < 12; $i++)
                                    <th class="text-center" style="font-size: 0.7rem;">H</th>
                                    <th class="text-center" style="font-size: 0.7rem;">I</th>
                                    <th class="text-center" style="font-size: 0.7rem;">S</th>
                                    <th class="text-center" style="font-size: 0.7rem;">A</th>
                                @endfor
                                <th class="text-center bg-success text-white">H</th>
                                <th class="text-center bg-warning">I</th>
                                <th class="text-center bg-info text-white">S</th>
                                <th class="text-center bg-danger text-white">A</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensiData as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $data['siswa']->nama_lengkap }}</td>
                                    @for($month = 1; $month <= 12; $month++)
                                        <td class="text-center">{{ $data['monthly'][$month]['hadir'] }}</td>
                                        <td class="text-center">{{ $data['monthly'][$month]['izin'] }}</td>
                                        <td class="text-center">{{ $data['monthly'][$month]['sakit'] }}</td>
                                        <td class="text-center">{{ $data['monthly'][$month]['alpha'] }}</td>
                                    @endfor
                                    <td class="text-center fw-bold">{{ $data['yearly']['hadir'] }}</td>
                                    <td class="text-center fw-bold">{{ $data['yearly']['izin'] }}</td>
                                    <td class="text-center fw-bold">{{ $data['yearly']['sakit'] }}</td>
                                    <td class="text-center fw-bold">{{ $data['yearly']['alpha'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @elseif($selectedKelas)
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                Tidak ada data absensi untuk tahun ini
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

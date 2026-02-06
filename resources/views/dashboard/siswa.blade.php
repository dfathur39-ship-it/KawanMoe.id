@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="live-clock h-100">
            <div class="clock-time" id="liveClock">00:00:00</div>
            <div class="clock-date" id="liveDate">Loading...</div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="row g-3">
            @if($siswa)
                <div class="col-6 col-md-4">
                    <div class="stat-card primary">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon primary"><i class="bi bi-person-badge"></i></div>
                            <div>
                                <div class="stat-value" style="font-size:1.2rem;">{{ $siswa->nis }}</div>
                                <div class="stat-label">NIS</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="stat-card success">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon success"><i class="bi bi-building"></i></div>
                            <div>
                                <div class="stat-value" style="font-size:1.2rem;">{{ $siswa->kelas->tingkat ?? '-' }} {{ $siswa->kelas->nama_kelas ?? '' }}</div>
                                <div class="stat-label">Kelas</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="stat-card info">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon info"><i class="bi bi-calendar-check"></i></div>
                            <div>
                                <div class="stat-value" style="font-size:1.2rem;">{{ isset($statsHariIni['status']) ? ucfirst($statsHariIni['status']) : '-' }}</div>
                                <div class="stat-label">Absen Hari Ini</div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(isset($statsHariIni['waktu_masuk']) && $statsHariIni['waktu_masuk'])
                <div class="col-6 col-md-4">
                    <div class="stat-card primary">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon primary"><i class="bi bi-clock-history"></i></div>
                            <div>
                                <div class="stat-value" style="font-size:1.2rem;">{{ \Carbon\Carbon::parse($statsHariIni['waktu_masuk'])->format('H:i') }}</div>
                                <div class="stat-label">Jam datang</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>

<div id="absen-info" class="row g-4 mb-4">
    <div class="col-12">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-qr-code-scan me-2"></i>Scan QR untuk Absen</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Scan QR code yang ditampilkan guru/admin di kelas (menu Tampilkan QR Absen). Setelah scan, Anda akan otomatis tercatat hadir.</p>
                <p class="text-muted mb-2"><i class="bi bi-info-circle me-1"></i>Izinkan akses kamera saat diminta. Arahkan kamera ke QR code di layar.</p>
                @if($siswa)
                <button type="button" class="btn btn-primary" id="btn-scan-qr" data-bs-toggle="modal" data-bs-target="#modal-scan-qr">
                    <i class="bi bi-camera me-2"></i>Buka pemindai QR
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

@if($siswa)
<div class="modal fade" id="modal-scan-qr" tabindex="-1" aria-labelledby="modal-scan-qr-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-scan-qr-label"><i class="bi bi-qr-code-scan me-2"></i>Pindai QR Absen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-0">
                <div id="qr-reader" style="width:100%;"></div>
                <p class="small text-muted p-2 mb-0">Arahkan kamera ke QR code yang ditampilkan admin</p>
            </div>
        </div>
    </div>
</div>
@endif

@if($siswa)
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Rekap Bulan Ini</h5></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#d1fae5;"><div class="fs-2 fw-bold text-success">{{ $statsBulanIni['hadir'] ?? 0 }}</div><div class="text-success">Hadir</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#fef3c7;"><div class="fs-2 fw-bold text-warning">{{ $statsBulanIni['izin'] ?? 0 }}</div><div class="text-warning">Izin</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#cffafe;"><div class="fs-2 fw-bold text-info">{{ $statsBulanIni['sakit'] ?? 0 }}</div><div class="text-info">Sakit</div></div></div>
                    <div class="col-6"><div class="p-3 rounded-3 text-center" style="background:#fee2e2;"><div class="fs-2 fw-bold text-danger">{{ $statsBulanIni['alpha'] ?? 0 }}</div><div class="text-danger">Alpha</div></div></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Riwayat Absensi Terbaru</h5></div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height:280px;">
                    <table class="table mb-0">
                        <thead style="position:sticky;top:0;background:white;"><tr><th>Tanggal</th><th>Status</th><th>Jam datang</th></tr></thead>
                        <tbody>
                            @forelse($absensiTerbaru as $absen)
                                <tr>
                                    <td>{{ $absen->tanggal->format('d/m/Y') }}</td>
                                    <td>{!! $absen->status_badge !!}</td>
                                    <td>{{ $absen->waktu_masuk ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-4">Belum ada riwayat</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">Data siswa tidak ditemukan. Hubungi admin.</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
function updateClock() {
    const now = new Date();
    document.getElementById('liveClock').textContent = now.toLocaleTimeString('id-ID');
    document.getElementById('liveDate').textContent = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
}
setInterval(updateClock, 1000); updateClock();

(function() {
    var modalEl = document.getElementById('modal-scan-qr');
    var btnScan = document.getElementById('btn-scan-qr');
    if (!modalEl || !btnScan) return;
    var scanner = null;
    var scanUrlPattern = /absen\/scan\/[a-zA-Z0-9]+/;

    function getScanUrl(text) {
        if (!text || !scanUrlPattern.test(text)) return null;
        if (text.indexOf('http') === 0) return text;
        var path = text.indexOf('/') === 0 ? text : '/' + text;
        return window.location.origin + path;
    }

    modalEl.addEventListener('show.bs.modal', function() {
        if (scanner) return;
        var readerEl = document.getElementById('qr-reader');
        if (!readerEl) return;
        scanner = new Html5Qrcode('qr-reader');
        scanner.start(
            { facingMode: 'environment' },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            function(decodedText) {
                var url = getScanUrl(decodedText);
                if (url) {
                    scanner.stop().then(function() { scanner = null; }).catch(function() { scanner = null; });
                    var b = document.querySelector('#modal-scan-qr [data-bs-dismiss="modal"]');
                    if (b) b.click();
                    window.location.href = url;
                }
            },
            function() {}
        ).catch(function(err) {
            console.error(err);
            if (readerEl) readerEl.innerHTML = '<p class="p-3 text-danger">Tidak bisa mengakses kamera. Izinkan akses kamera di pengaturan browser.</p>';
        });
    });

    modalEl.addEventListener('hidden.bs.modal', function() {
        if (scanner) {
            scanner.stop().then(function() { scanner = null; }).catch(function() { scanner = null; });
        }
    });
})();
</script>
@endpush

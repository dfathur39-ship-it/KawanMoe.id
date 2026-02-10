@extends('layouts.app')

@section('title', 'QR Absen')

@push('styles')
<style>
#qrcode-wrapper:fullscreen,
#qrcode-wrapper:-webkit-full-screen,
#qrcode-wrapper:-moz-full-screen {
    display: flex !important;
    justify-content: center;
    align-items: center;
    width: 100%;
    min-height: 100%;
    height: 100%;
    background: #fff; /* putih saat fullscreen agar QR mudah di-scan */
    box-sizing: border-box;
}
#qrcode-wrapper:fullscreen #qrcode,
#qrcode-wrapper:-webkit-full-screen #qrcode,
#qrcode-wrapper:-moz-full-screen #qrcode {
    display: block;
    margin: auto;
}
</style>
@endpush

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-qr-code me-2"></i>Tampilkan QR Code Absen</h5>
            </div>
            <div class="card-body text-center">
                <p class="text-muted mb-3">Siswa scan QR code ini menggunakan kamera HP untuk absen. Kode otomatis berganti setiap 3 detik.</p>
                <p class="small text-muted mb-2"><i class="bi bi-hand-index me-1"></i>Ketuk 2 kali QR code untuk full screen</p>
                <div id="qrcode-wrapper" class="mb-3 p-4 rounded-3 d-inline-block" role="button" tabindex="0" style="cursor:pointer;background:#334155;">
                    <canvas id="qrcode"></canvas>
                </div>
                <p class="small text-muted mb-2">Berakhir: <span id="countdown-text">00:00:03 tersisa</span></p>
                <a href="{{ route('qrabsen.show') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-arrow-clockwise me-2"></i>Refresh halaman</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1/build/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var canvas = document.getElementById('qrcode');
    var countdownEl = document.getElementById('countdown-text');
    var countdownInterval = null;

    function drawQr(url) {
        QRCode.toCanvas(canvas, url, { width: 280, margin: 2 }, function(err) {
            if (err) console.error(err);
        });
    }

    function startCountdown(expiresAtUnix) {
        if (countdownInterval) clearInterval(countdownInterval);
        function tick() {
            var now = Math.floor(Date.now() / 1000);
            var left = expiresAtUnix - now;
            if (left <= 0) {
                countdownEl.textContent = 'Memperbarui...';
                return;
            }
            var m = Math.floor(left / 60);
            var s = left % 60;
            countdownEl.textContent = '00:' + (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s + ' tersisa';
        }
        tick();
        countdownInterval = setInterval(tick, 1000);
    }

    function refreshQr() {
        fetch('{{ route("qrabsen.refresh") }}', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                drawQr(data.scanUrl);
                startCountdown(data.expiresAt);
            })
            .catch(function() {
                countdownEl.textContent = 'Gagal refresh. Coba refresh halaman.';
            });
    }

    // Tampilkan QR pertama (dari server)
    drawQr(@json($scanUrl));
    startCountdown(@json($expiresAt->timestamp));

    // Setiap 3 detik auto-generate QR baru
    setInterval(refreshQr, 3000);

    function toggleFullscreen() {
        var wrapper = document.getElementById('qrcode-wrapper');
        if (!document.fullscreenElement) {
            wrapper.requestFullscreen().catch(function(err) { alert('Full screen tidak didukung: ' + err.message); });
        } else {
            document.exitFullscreen();
        }
    }
    document.getElementById('qrcode-wrapper').addEventListener('dblclick', toggleFullscreen);
});
</script>
@endpush

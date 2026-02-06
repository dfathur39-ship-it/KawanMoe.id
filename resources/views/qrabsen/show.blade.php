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
    background: #fff;
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
                <p class="text-muted mb-3">Siswa scan QR code ini menggunakan kamera HP untuk absen. Kode berlaku 3 detik.</p>
                <p class="small text-muted mb-2"><i class="bi bi-hand-index me-1"></i>Ketuk 2 kali QR code untuk full screen</p>
                <div id="qrcode-wrapper" class="mb-3 p-4 bg-light rounded-3 d-inline-block" role="button" tabindex="0" style="cursor:pointer;">
                    <canvas id="qrcode"></canvas>
                </div>
                <p class="small text-muted mb-2">Berakhir: <span id="countdown-text">{{ $expiresAt->format('H:i:s') }} ({{ $expiresAt->diffForHumans() }})</span></p>
                <a href="{{ route('qrabsen.show') }}" class="btn btn-primary"><i class="bi bi-arrow-clockwise me-2"></i>Generate QR Baru</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode@1/build/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const expiresAtUnix = @json($expiresAt->timestamp);
    const url = @json($scanUrl);
    QRCode.toCanvas(document.getElementById('qrcode'), url, { width: 280, margin: 2 }, function(err) {
        if (err) console.error(err);
    });
    var countdownEl = document.getElementById('countdown-text');
    function updateCountdown() {
        var now = Math.floor(Date.now() / 1000);
        var left = expiresAtUnix - now;
        if (left <= 0) {
            countdownEl.textContent = 'Kode berakhir. Klik "Generate QR Baru" untuk QR baru.';
            clearInterval(countdownInterval);
            return;
        }
        var m = Math.floor(left / 60);
        var s = left % 60;
        countdownEl.textContent = '00:' + (m < 10 ? '0' : '') + m + ':' + (s < 10 ? '0' : '') + s + ' tersisa';
    }
    var countdownInterval = setInterval(updateCountdown, 1000);
    updateCountdown();

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

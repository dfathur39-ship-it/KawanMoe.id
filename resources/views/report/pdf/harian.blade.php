<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Harian</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; color: #6366f1; }
        .header h2 { margin: 5px 0; font-size: 16px; }
        .info table { width: 100%; }
        .info td { padding: 3px 0; }
        .info .label { width: 120px; font-weight: bold; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data th, table.data td { border: 1px solid #333; padding: 8px; }
        table.data th { background: #6366f1; color: white; text-align: center; }
        .status-hadir { color: #10b981; font-weight: bold; }
        .status-izin { color: #f59e0b; font-weight: bold; }
        .status-sakit { color: #06b6d4; font-weight: bold; }
        .status-alpha { color: #ef4444; font-weight: bold; }
        .summary { margin-top: 20px; padding: 15px; background: #f8f9fa; }
        .footer { position: fixed; bottom: 20px; right: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Absensi Siswa</h1>
        <h2>LAPORAN ABSENSI HARIAN</h2>
    </div>
    <div class="info">
        <table>
            <tr><td class="label">Kelas</td><td>: {{ $kelas->tingkat }} {{ $kelas->nama_kelas }} {{ $kelas->jurusan ? '- '.$kelas->jurusan : '' }}</td></tr>
            <tr><td class="label">Tanggal</td><td>: {{ $tanggal->translatedFormat('l, d F Y') }}</td></tr>
            <tr><td class="label">Wali Kelas</td><td>: {{ $kelas->wali_kelas ?? '-' }}</td></tr>
        </table>
    </div>
    <table class="data">
        <thead>
            <tr>
                <th width="40">No</th>
                <th width="80">NIS</th>
                <th>Nama Siswa</th>
                <th width="40">L/P</th>
                <th width="80">Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $stats = ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0]; @endphp
            @foreach($siswaList as $index => $siswa)
                @php
                    $absenSiswa = $absensi->get($siswa->id);
                    $status = $absenSiswa->status ?? 'alpha';
                    $stats[$status]++;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama_lengkap }}</td>
                    <td style="text-align: center;">{{ $siswa->jenis_kelamin }}</td>
                    <td style="text-align: center;" class="status-{{ $status }}">{{ strtoupper($status) }}</td>
                    <td>{{ $absenSiswa->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="summary">
        <h4>Ringkasan: Hadir {{ $stats['hadir'] }}, Izin {{ $stats['izin'] }}, Sakit {{ $stats['sakit'] }}, Alpha {{ $stats['alpha'] }}</h4>
    </div>
    <div class="footer">
        <p>{{ $kelas->wali_kelas ?? '.........................' }}</p>
        <p><strong>Wali Kelas</strong></p>
    </div>
</body>
</html>

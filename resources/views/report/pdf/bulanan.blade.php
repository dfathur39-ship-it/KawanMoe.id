<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Bulanan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 9px; margin: 0; padding: 15px; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { margin: 0; font-size: 16px; color: #6366f1; }
        .header h2 { margin: 5px 0; font-size: 14px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #333; padding: 4px 2px; text-align: center; font-size: 8px; }
        table.data th { background: #6366f1; color: white; }
        table.data td.name { text-align: left; padding-left: 5px; white-space: nowrap; }
        .H { background: #d1fae5; color: #065f46; font-weight: bold; }
        .I { background: #fef3c7; color: #92400e; font-weight: bold; }
        .S { background: #cffafe; color: #155e75; font-weight: bold; }
        .A { background: #fee2e2; color: #991b1b; font-weight: bold; }
        .total { background: #f1f5f9; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Absensi Siswa</h1>
        <h2>LAPORAN ABSENSI BULANAN - {{ $namaBulan }} {{ $tahun }}</h2>
        <p>Kelas: {{ $kelas->tingkat }} {{ $kelas->nama_kelas }} {{ $kelas->jurusan ? '- '.$kelas->jurusan : '' }}</p>
    </div>
    <table class="data">
        <thead>
            <tr>
                <th rowspan="2" style="min-width:30px;">No</th>
                <th rowspan="2" class="name">Nama</th>
                @for($i = 1; $i <= $daysInMonth; $i++)
                    <th>{{ $i }}</th>
                @endfor
                <th class="total">H</th>
                <th class="total">I</th>
                <th class="total">S</th>
                <th class="total">A</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensiData as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="name">{{ $data['siswa']->nama_lengkap }}</td>
                    @for($i = 1; $i <= $daysInMonth; $i++)
                        @php
                            $absen = $data['absensi']->get($i);
                            $status = $absen ? strtoupper(substr($absen->status, 0, 1)) : '-';
                            $class = $absen ? (match($absen->status) { 'hadir' => 'H', 'izin' => 'I', 'sakit' => 'S', 'alpha' => 'A', default => '' }) : '';
                        @endphp
                        <td class="{{ $class }}">{{ $status }}</td>
                    @endfor
                    <td class="total">{{ $data['summary']['hadir'] }}</td>
                    <td class="total">{{ $data['summary']['izin'] }}</td>
                    <td class="total">{{ $data['summary']['sakit'] }}</td>
                    <td class="total">{{ $data['summary']['alpha'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

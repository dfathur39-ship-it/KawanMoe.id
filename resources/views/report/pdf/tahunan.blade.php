<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Tahunan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 8px; margin: 0; padding: 10px; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 10px; margin-bottom: 15px; }
        .header h1 { margin: 0; font-size: 16px; color: #6366f1; }
        .header h2 { margin: 5px 0; font-size: 14px; }
        table.data { width: 100%; border-collapse: collapse; }
        table.data th, table.data td { border: 1px solid #333; padding: 3px 2px; text-align: center; font-size: 7px; }
        table.data th { background: #6366f1; color: white; }
        table.data td.name { text-align: left; padding-left: 5px; white-space: nowrap; font-size: 8px; }
        .total-col { background: #f1f5f9; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Absensi Siswa</h1>
        <h2>LAPORAN ABSENSI TAHUNAN {{ $tahun }}</h2>
        <p>Kelas: {{ $kelas->tingkat }} {{ $kelas->nama_kelas }} {{ $kelas->jurusan ? '- '.$kelas->jurusan : '' }}</p>
    </div>
    <table class="data">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2" class="name">Nama</th>
                @php $bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']; @endphp
                @foreach($bulanNames as $b)
                    <th colspan="4">{{ $b }}</th>
                @endforeach
                <th colspan="4" class="total-col">Total</th>
            </tr>
            <tr>
                @for($i = 0; $i < 12; $i++)
                    <th>H</th><th>I</th><th>S</th><th>A</th>
                @endfor
                <th class="total-col">H</th><th class="total-col">I</th><th class="total-col">S</th><th class="total-col">A</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensiData as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="name">{{ $data['siswa']->nama_lengkap }}</td>
                    @for($month = 1; $month <= 12; $month++)
                        <td>{{ $data['monthly'][$month]['hadir'] }}</td>
                        <td>{{ $data['monthly'][$month]['izin'] }}</td>
                        <td>{{ $data['monthly'][$month]['sakit'] }}</td>
                        <td>{{ $data['monthly'][$month]['alpha'] }}</td>
                    @endfor
                    <td class="total-col">{{ $data['yearly']['hadir'] }}</td>
                    <td class="total-col">{{ $data['yearly']['izin'] }}</td>
                    <td class="total-col">{{ $data['yearly']['sakit'] }}</td>
                    <td class="total-col">{{ $data['yearly']['alpha'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

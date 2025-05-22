<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Iuran Kas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Rekap Iuran Kas PPSG Candisingo</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>RT</th>
                <th>Anggota Wajib Bayar</th>
                <th>Membayar</th>
                <th>Belum Membayar</th>
                <th>Anggota Tidak Aktif</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekapan as $item)
                <tr>
                    <td>{{ $item['tanggal_pertemuan'] }}</td>
                    <td>{{ $item['rt'] }}</td>
                    <td>{{ $item['total_wajib'] }}</td>
                    <td>{{ $item['membayar'] }}</td>
                    <td>{{ $item['tidak_membayar'] }}</td>
                    <td>{{ $item['tidak_aktif'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan PPSG</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #eee;
            text-align: center;
        }
        tfoot td {
            font-weight: bold;
            /* background-color: #f5f5f5; */
        }
        .text-right {
            text-align: right;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Laporan Keuangan PPSG</h2>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Masuk</th>
                <th>Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($catatan as $c)
            <tr>
                <td>{{ \Carbon\Carbon::parse($c->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                <td>{{ $c->deskripsi }}</td>
                <td class="text-right">
                    {{ $c->masuk ? 'Rp ' . number_format($c->masuk, 0, ',', '.') : '-' }}
                </td>
                <td class="text-right">
                    {{ $c->keluar ? 'Rp ' . number_format($c->keluar, 0, ',', '.') : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" class="text-right">Total Masuk</td>
                <td class="text-right">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">Total Keluar</td>
                <td></td>
                <td class="text-right">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">Saldo Akhir</td>
                <td colspan="2" class="text-right">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

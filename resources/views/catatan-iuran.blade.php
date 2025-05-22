<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Catatan Iuran Kas RT {{ $catatanIuran->rt }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
        .success {
            background-color: #28a745;
        }
        .danger {
            background-color: #dc3545;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 6px;
            border: 1px solid #999;
            text-align: left;
        }
        th {
            background-color: #f3f3f3;
        }
        h2 {
            text-align: left;
            margin-bottom: 0;
        }
        .meta {
            margin-top: 5px;
            text-align: left;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <h2>Catatan Iuran Kas RT {{ $catatanIuran->rt }}</h2>
    <p class="meta">Tanggal Pertemuan: {{ \Carbon\Carbon::parse($catatanIuran->tanggal_pertemuan)->locale('id')->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Status Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggotaList as $index => $anggota)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $anggota->nama }}</td>
                    <td>
                        @if ($anggota->pivot->status_bayar)
                            <span class="badge success">Sudah Bayar</span>
                        @else
                            <span class="badge danger">Belum Bayar</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

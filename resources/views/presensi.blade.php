<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Presensi Kegiatan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2 {
            margin-bottom: 5px;
        }

        p {
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        td.no {
            width: 30px;
            text-align: left;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 2px;
            font-size: 11px;
            font-weight: bold;
            color: #fff;
        }

        .badge-hadir {
            background-color: #28a745;
        }

        .badge-izin {
            background-color: #ffbf00e4;
        }

        .badge-tidak {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <h2>Presensi Kegiatan: {{ $acara->nama }}</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($acara->waktu_mulai)->locale('id')->translatedFormat('d F Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th class="no">No</th>
                <th>Nama Anggota</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($presensis as $i => $presensi)
                <tr>
                    <td class="no">{{ $i + 1 }}</td>
                    <td>{{ $presensi->anggota->nama }}</td>
                    <td>
                        @php
                            $status = ucfirst(strtolower($presensi->status));
                            $badgeClass = match($status) {
                                'Hadir' => 'badge-hadir',
                                'Izin' => 'badge-izin',
                                'Tidak hadir' => 'badge-tidak',
                                default => ''
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Presensi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        h2 {
            text-align: center;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background: #f0f0f0;
        }
        .inactive {
            background-color: #ff2739;
        }

        /* Lebar kolom */
        .col-no { width: 5%; text-align: center; }
        .col-nama { width: 35%; }
        .col-hadir, .col-izin, .col-tidak-hadir { width: 10%; text-align: center; }
        .col-total { width: 15%; text-align: center; }
    </style>
</head>
<body>
    <h2>Rekap Presensi Kegiatan</h2>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-nama">Nama Anggota</th>
                <th class="col-hadir">Hadir</th>
                <th class="col-izin">Izin</th>
                <th class="col-tidak-hadir">Tidak Hadir</th>
                <th class="col-total">Jumlah Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggota as $index => $a)
                <tr @if ($a->status_keanggotaan === 'tidak aktif') class="inactive" @endif>
                    <td class="col-no">{{ $index + 1 }}</td>
                    <td class="col-nama">{{ $a->nama }}</td>
                    <td class="col-hadir">{{ $a->hadir_count ?? 0 }}</td>
                    <td class="col-izin">{{ $a->izin_count ?? 0 }}</td>
                    <td class="col-tidak-hadir">{{ $a->tidak_hadir_count ?? 0 }}</td>
                    <td class="col-total">{{ $a->total_kegiatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 10px;"><strong>Catatan:</strong> Baris berwarna merah menunjukkan anggota yang sudah tidak aktif.</p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Data Anggota PPSG Candisingo</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #dbdbdb;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Data Anggota PPSG Candisingo</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Agama</th>
                <th>RT</th>
                <th>Gol Darah</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($anggotas as $anggota)
                <tr>
                    <td>{{ $anggota->nama }}</td>
                    <td>{{ $anggota->tempat_tgl_lahir }}</td>
                    <td>{{ $anggota->jenis_kelamin }}</td>
                    <td>{{ $anggota->agama }}</td>
                    <td>{{ $anggota->rt }}</td>
                    <td>{{ $anggota->gol_darah }}</td>
                    <td>{{ $anggota->no_hp }}</td>
                    <td>{{ $anggota->user ? $anggota->user->email : 'Tidak Ada' }}</td>
                     <td>{{ $anggota->status_keanggotaan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

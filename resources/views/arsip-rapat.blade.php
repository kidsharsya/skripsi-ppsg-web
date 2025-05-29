<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Arsip Rapat PPSG Candisingo</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
            margin-left: 30px;
            margin-right: 30px;
        }
        h1 { font-size: 18px; margin-bottom: 10px; }
        p { margin: 5px 0; }
        .section { margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="section">
        <h1>{{ $arsip->judul_rapat }}</h1>
    </div>

    <div class="section">
        <strong>Tanggal:</strong><br>
        {{ \Carbon\Carbon::parse($arsip->tanggal_rapat)->translatedFormat('d F Y') }}
    </div>

    <div class="section">
        <strong>Notulensi:</strong><br>
        {!! \Illuminate\Support\Str::markdown($arsip->notulensi) !!}
    </div>
</body>
</html>

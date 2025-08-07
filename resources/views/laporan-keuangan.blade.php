<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan PPSG</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .summary-box {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .summary-title {
            background-color: #DBEAFE;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            color: #1E40AF;
        }
        .summary-content {
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }
        .summary-item {
            text-align: center;
            padding: 10px;
            border-radius: 6px;
            flex: 1;
            margin: 0 5px;
        }
        .summary-item.masuk {
            background-color: #F0FDF4;
        }
        .summary-item.keluar {
            background-color: #FEF2F2;
        }
        .summary-item.saldo {
            background-color: #EFF6FF;
        }
        .month-box {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .month-header {
            background-color: #FEF3C7;
            padding: 10px;
            text-align: center;
            font-weight: bold;
        }
        .transactions {
            display: flex;
        }
        .transactions-column {
            flex: 1;
            border-right: 1px solid #ddd;
        }
        .transactions-column:last-child {
            border-right: none;
        }
        .column-header {
            background-color: #F9FAFB;
            padding: 8px;
            text-align: center;
            font-weight: bold;
        }
        .masuk-header {
            color: #047857;
        }
        .keluar-header {
            color: #DC2626;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #F3F4F6;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-green {
            color: #047857;
        }
        .text-red {
            color: #DC2626;
        }
        .text-blue {
            color: #1E40AF;
        }
        .month-summary {
            background-color: #F9FAFB;
            padding: 10px;
            border-top: 1px solid #ddd;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Laporan Keuangan PPSG Candisingo</h2>
        </div>

        <!-- Summary Box -->
        <div class="summary-box">
            <div class="summary-title">RINGKASAN TOTAL</div>
            <div class="summary-content">
                <div class="summary-item masuk">
                    <div>Total Pemasukan</div>
                    <div class="text-green">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</div>
                </div>
                <div class="summary-item keluar">
                    <div>Total Pengeluaran</div>
                    <div class="text-red">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</div>
                </div>
                <div class="summary-item saldo">
                    <div>Saldo Akhir</div>
                    <div class="text-blue">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        @php
            \Carbon\Carbon::setLocale('id');
            $groupedData = collect($catatan)
                ->sortByDesc('tanggal')
                ->groupBy(function($item) {
                    return \Carbon\Carbon::parse($item->tanggal)->format('Y-m');
                })
                ->map(function ($items, $yearMonth) {
                    return [
                        'transactions' => $items,
                        'label' => \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->translatedFormat('F Y'),
                        'total_masuk' => $items->sum('masuk'),
                        'total_keluar' => $items->sum('keluar')
                    ];
                });
        @endphp

        @foreach($groupedData as $monthData)
        <div class="month-box">
            <div class="month-header">{{ $monthData['label'] }}</div>
            <div class="transactions">
                <!-- Kolom Uang Masuk -->
                <div class="transactions-column">
                    <div class="column-header masuk-header">Uang Masuk</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthData['transactions']->where('masuk', '>', 0) as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td class="text-right text-green">Rp {{ number_format($item->masuk, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Kolom Uang Keluar -->
                <div class="transactions-column">
                    <div class="column-header keluar-header">Uang Keluar</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthData['transactions']->where('keluar', '>', 0) as $item)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td class="text-right text-red">Rp {{ number_format($item->keluar, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Month Summary -->
            <div class="month-summary">
                <div style="margin-bottom: 8px;">
                    <span>Total Masuk: </span>
                    <span class="text-green">Rp {{ number_format($monthData['total_masuk'], 0, ',', '.') }}</span>
                    <span style="margin: 0 10px;">|</span>
                    <span>Total Keluar: </span>
                    <span class="text-red">Rp {{ number_format($monthData['total_keluar'], 0, ',', '.') }}</span>
                </div>
                <div>
                    <span>Saldo Bulan Ini: </span>
                    <span class="text-blue">Rp {{ number_format($monthData['total_masuk'] - $monthData['total_keluar'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</body>
</html>

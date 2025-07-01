<x-filament-panels::page>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 border rounded-lg">
        <thead style="background-color: #bfdbfe">
            <tr>
                <th class="py-3 px-6 text-left border-b font-semibold text-gray-700">Periode</th>
                <th class="py-3 px-6 text-left border-b font-semibold text-gray-700">Total Pemasukan</th>
                <th class="py-3 px-6 text-left border-b font-semibold text-gray-700">Total Pengeluaran</th>
                <th class="py-3 px-6 text-left border-b font-semibold text-gray-700">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporanKeuangan as $laporan)
                <tr>
                    <td class="py-3 px-6 border-b whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($laporan->periode . '-01')->locale('id')->translatedFormat('F Y') }}
                    </td>
                    <td class="py-3 px-6 border-b text-green-600 whitespace-nowrap">
                        Rp {{ number_format($laporan->total_pemasukan, 2, ',', '.') }}
                    </td>
                    <td class="py-3 px-6 border-b text-red-600 whitespace-nowrap">
                        Rp {{ number_format($laporan->total_pengeluaran, 2, ',', '.') }}
                    </td>
                    <td class="py-3 px-6 border-b text-blue-600 whitespace-nowrap">
                        Rp {{ number_format($laporan->saldo_akhir, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-filament-panels::page>

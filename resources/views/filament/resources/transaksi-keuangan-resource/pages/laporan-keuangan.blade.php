<x-filament::page>

    

    <!-- Tabel Laporan Keuangan per Periode -->
<div class="overflow-x-auto shadow-sm rounded-lg">
    <table class="min-w-full bg-white border rounded-lg">
        <thead style="background-color: #bfdbfe">
            <tr>
                <th class="py-3 px-4 text-left border-b font-semibold text-gray-700">Periode</th>
                <th class="py-3 px-4 text-left border-b font-semibold text-gray-700">Total Pemasukan</th>
                <th class="py-3 px-4 text-left border-b font-semibold text-gray-700">Total Pengeluaran</th>
                <th class="py-3 px-4 text-left border-b font-semibold text-gray-700">Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporanKeuangan as $laporan)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 border-b whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($laporan->periode . '-01')->locale('id')->translatedFormat('F Y') }}
                    </td>
                    <td class="py-3 px-4 border-b text-green-600 whitespace-nowrap">
                        Rp {{ number_format($laporan->total_pemasukan, 2, ',', '.') }}
                    </td>
                    <td class="py-3 px-4 border-b text-red-600 whitespace-nowrap">
                        Rp {{ number_format($laporan->total_pengeluaran, 2, ',', '.') }}
                    </td>
                    <td class="py-3 px-4 border-b text-blue-600 whitespace-nowrap">
                        Rp {{ number_format($laporan->saldo_akhir, 2, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Bagian Total Keseluruhan -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 mb-4">
    <div style="background-color: #d1fae5;" class="p-6 rounded-lg shadow">
        <div class="text-center">
            <p class="text-lg">Total Pemasukan Keseluruhan</p>
            <p class="text-2xl text-green-600 mt-2 font-bold">Rp {{ number_format($totalPemasukan, 2, ',', '.') }}</p>
        </div>
    </div>

    <div style="background-color: #fecaca;" class="p-6 rounded-lg shadow">
        <div class="text-center">
            <p class="text-lg">Total Pengeluaran Keseluruhan</p>
            <p class="text-2xl text-red-600 mt-2 font-bold">Rp {{ number_format($totalPengeluaran, 2, ',', '.') }}</p>
        </div>
    </div>

    <div style="background-color: #bfdbfe;" class="p-6 rounded-lg shadow">
        <div class="text-center">
            <p class="text-lg">Saldo Akhir Keseluruhan</p>
            <p class="text-2xl text-blue-600 mt-2 font-bold">Rp {{ number_format($saldoAkhir, 2, ',', '.') }}</p>
        </div>
    </div>
</div>
    
</x-filament::page>

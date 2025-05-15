<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 mb-4">
            <!-- Total Pemasukan Keseluruhan -->
            <div style="border: 4px solid #62946B;" class="p-6 rounded-lg shadow">
                <div class="text-center">
                    <p class="text-lg">Total Pemasukan Keseluruhan</p>
                    <p class="text-2xl text-green-600 mt-2 font-bold">Rp {{ number_format($totalPemasukan, 2, ',', '.') }}</p>
                </div>
            </div>

            <!-- Total Pengeluaran Keseluruhan -->
            <div style="border: 4px solid #BE6F6F;" class="p-6 rounded-lg shadow">
                <div class="text-center">
                    <p class="text-lg">Total Pengeluaran Keseluruhan</p>
                    <p class="text-2xl text-red-600 mt-2 font-bold">Rp {{ number_format($totalPengeluaran, 2, ',', '.') }}</p>
                </div>
            </div>

            <!-- Saldo Akhir Keseluruhan -->
            <div style="border: 4px solid #7A78C2;" class="p-6 rounded-lg shadow">
                <div class="text-center">
                    <p class="text-lg">Saldo Akhir Keseluruhan</p>
                    <p class="text-2xl text-blue-600 mt-2 font-bold">Rp {{ number_format($saldoAkhir, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

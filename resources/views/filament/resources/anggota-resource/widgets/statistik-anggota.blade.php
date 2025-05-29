<x-filament-widgets::widget>
    <x-filament::section>
        <style>
            /* Responsive: 2 kolom di layar kecil (≤480px) */
            @media (max-width: 480px) {
                .grid-box {
                    flex-wrap: wrap !important;
                    justify-content: center !important;
                }

                .box {
                    width: 45% !important;
                    margin-bottom: 12px;
                }
            }
        </style>

        {{-- Judul Bagian RT --}}
        <h2 style="text-align: center; font-size: 14px; font-weight: 600; margin-bottom: 16px;">
            Jumlah Anggota Per RT
        </h2>

        {{-- Grid RT 01 - 06 --}}
        <div class="grid-box" style="display: flex; flex-wrap: nowrap; justify-content: center; gap: 16px; margin-bottom: 24px;">
            @foreach ([
                'RT 01' => $jumlahRt01,
                'RT 02' => $jumlahRt02,
                'RT 03' => $jumlahRt03,
                'RT 04' => $jumlahRt04,
                'RT 05' => $jumlahRt05,
                'RT 06' => $jumlahRt06,
            ] as $label => $jumlah)
                <div class="box" style="text-align: center; border: 1px solid #000; border-radius: 8px; padding: 10px 16px; width: 150px;">
                    <div style="font-size: 12px; color: #555;">{{ $label }}</div>
                    <div style="font-size: 18px; font-weight: bold;">{{ $jumlah }}</div>
                </div>
            @endforeach
        </div>

        {{-- Judul Bagian Gender --}}
        <h2 style="text-align: center; font-size: 14px; font-weight: 600; margin-bottom: 16px;">
            Jumlah Berdasarkan Gender
        </h2>

        {{-- Grid Gender --}}
        <div class="grid-box" style="display: flex; flex-wrap: nowrap; justify-content: center; gap: 16px;">
            @foreach ([
                'Laki-Laki' => $jumlahLaki,
                'Perempuan' => $jumlahPerempuan,
            ] as $label => $jumlah)
                <div class="box" style="text-align: center; border: 1px solid #000; border-radius: 8px; padding: 12px 20px; width: 150px;">
                    <div style="font-size: 12px; color: #555;">{{ $label }}</div>
                    <div style="font-size: 18px; font-weight: bold;">{{ $jumlah }}</div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

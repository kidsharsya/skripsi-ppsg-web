<x-filament::page>
    <div class="flex justify-end">
        <a href="{{ route('rekap-presensi.export') }}" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700">
            Export PDF
        </a>
    </div>

    {{ $this->table }}
</x-filament::page>

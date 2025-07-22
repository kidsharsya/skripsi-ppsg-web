<div class="space-y-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Acara</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($presensis as $presensi)
                    <tr>
                        <td class="px-6 py-4 whitespace-normal text-sm text-gray-900">
                            {{ $presensi->acara->nama }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($presensi->acara->waktu_mulai)->locale('id')->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-normal text-sm">
                            <div @class([
                                'inline-flex items-center rounded-full px-2 py-1 text-xs font-medium',
                                'bg-green-100 text-green-700' => $presensi->status === 'Hadir',
                                'bg-yellow-100 text-yellow-700' => $presensi->status === 'Izin',
                                'bg-red-100 text-red-700' => $presensi->status === 'Tidak Hadir',
                            ])>
                                {{ $presensi->status }}
                            </div>
                            @if($presensi->status === 'Izin' && $presensi->alasan)
                                <div class="mt-1 text-xs text-gray-500">
                                    <span class="font-medium">Alasan:</span> {{ $presensi->alasan }}
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
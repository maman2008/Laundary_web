<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Absensi Karyawan</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Dari Tanggal</label>
                        <input type="date" name="from" value="{{ $from }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Sampai Tanggal</label>
                        <input type="date" name="until" value="{{ $until }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="flex items-end">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="hanya_telat" value="1" {{ $hanyaTelat ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700">Hanya Telat</span>
                        </label>
                    </div>
                    <div class="flex items-end">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Check In</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Check Out</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lat/Lng</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Telat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($attendances as $a)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $a->user->name }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $a->check_in_at }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $a->check_out_at ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($a->photo_path)
                                            <img src="{{ asset($a->photo_path) }}" alt="foto" class="h-12 w-12 object-cover rounded">
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">{{ $a->lat }}, {{ $a->lng }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        <span class="px-2 py-1 rounded text-xs {{ $a->is_late ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">{{ $a->is_late ? 'Telat' : 'Tepat Waktu' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $attendances->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Izin Tidak Masuk Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('status'))
                        <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
                    @endif

                    <div class="mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            @php($active = $status ?? '')
                            <a href="{{ route('izin.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $active==='' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Semua</a>
                            <a href="{{ route('izin.index', ['status' => 'pending']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $active==='pending' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Pending</a>
                            <a href="{{ route('izin.index', ['status' => 'accepted']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $active==='accepted' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Disetujui</a>
                            <a href="{{ route('izin.index', ['status' => 'rejected']) }}" class="px-3 py-1.5 rounded-lg text-xs font-medium {{ $active==='rejected' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Ditolak</a>
                        </div>
                        <a href="{{ route('izin.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700">
                            Ajukan Izin
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lampiran</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($requests as $r)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $r->created_at?->format('Y-m-d H:i') }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-900 font-medium">{{ $r->start_date }} s/d {{ $r->end_date }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $r->description ?? '-' }}</td>
                                        <td class="px-4 py-3 text-sm">
                                            <span class="px-2 py-1 rounded text-xs {{ $r->status === 'accepted' ? 'bg-green-100 text-green-700' : ($r->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ ucfirst($r->status) }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-sm">
                                            @if ($r->attachment_path)
                                                <a href="{{ asset('storage/'.$r->attachment_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada pengajuan izin.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $requests->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

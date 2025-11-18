<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pengajuan Karyawan</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">
                @if (session('status'))
                    <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
                @endif

                <form method="GET" class="flex items-end gap-3 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Status</label>
                        <select name="status" class="border rounded px-3 py-2">
                            <option value="">Semua</option>
                            <option value="pending" @selected(request('status')==='pending')>Pending</option>
                            <option value="accepted" @selected(request('status')==='accepted')>Diterima</option>
                            <option value="rejected" @selected(request('status')==='rejected')>Ditolak</option>
                        </select>
                    </div>
                    <div>
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipe</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lampiran</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($requests as $r)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $r->user->name }}</td>
                                    <td class="px-4 py-2 text-sm">{{ ucfirst($r->type) }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $r->title }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $r->start_date }} @if($r->end_date) - {{ $r->end_date }} @endif</td>
                                    <td class="px-4 py-2 text-sm">
                                        @if ($r->attachment_path)
                                            <a href="{{ asset('storage/'.$r->attachment_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <span class="px-2 py-1 rounded text-xs {{ $r->status==='accepted' ? 'bg-emerald-100 text-emerald-700' : ($r->status==='rejected' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">{{ ucfirst($r->status) }}</span>
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        <div class="flex gap-2">
                                            <form method="POST" action="{{ route('admin.requests.accept', $r->id) }}">
                                                @csrf
                                                <button class="px-3 py-1 rounded bg-emerald-600 text-white text-xs" @disabled($r->status==='accepted')>Terima</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.requests.reject', $r->id) }}">
                                                @csrf
                                                <button class="px-3 py-1 rounded bg-rose-600 text-white text-xs" @disabled($r->status==='rejected')>Tolak</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $requests->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

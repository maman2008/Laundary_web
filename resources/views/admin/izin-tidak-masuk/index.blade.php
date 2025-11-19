<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin Tidak Masuk - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .status-badge{font-size:.75rem;padding:.25rem .75rem;border-radius:9999px;font-weight:500}
        .table-container{overflow-x:auto;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.08)}
    </style>
</head>
<body class="bg-gray-50 font-sans">
<div class="min-h-screen">
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 text-indigo-600 hover:text-indigo-800 transition-colors">
                        <i class="fas fa-arrow-left"></i>
                        <span class="hidden sm:inline">Kembali ke Dashboard</span>
                    </a>
                    <div class="h-6 border-l border-gray-300"></div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Izin Tidak Masuk</h1>
                        <p class="text-sm text-gray-600 mt-1">Kelola pengajuan izin tidak masuk (sakit/pribadi/lainnya)</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl p-6 shadow mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua</option>
                            <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ request('status')==='accepted' ? 'selected' : '' }}>Diterima</option>
                            <option value="rejected" {{ request('status')==='rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" class="px-4 py-3 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-filter mr-2"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('admin.izin.index') }}" class="px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Daftar Izin Tidak Masuk</h2>
                    <div class="text-sm text-gray-500">Total: <span class="font-semibold">{{ $requests->total() }}</span> izin</div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Karyawan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lampiran</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($requests as $r)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-semibold mr-3">
                                            {{ strtoupper(substr($r->user->name,0,1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $r->user->name }}</div>
                                            <div class="text-xs text-gray-500">Diajukan: {{ $r->created_at?->format('d M Y H:i') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $r->start_date }} s/d {{ $r->end_date }}
                                </td>
                                <td class="px-6 py-4 text-sm max-w-xs">
                                    {{ $r->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($r->attachment_path)
                                        <a href="{{ asset('storage/'.$r->attachment_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($r->status === 'accepted')
                                        <span class="status-badge bg-emerald-100 text-emerald-700">Diterima</span>
                                    @elseif($r->status === 'rejected')
                                        <span class="status-badge bg-rose-100 text-rose-700">Ditolak</span>
                                    @else
                                        <span class="status-badge bg-amber-100 text-amber-700">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if ($r->status === 'pending')
                                        <div class="flex gap-2">
                                            <form method="POST" action="{{ route('admin.izin.accept', $r->id) }}">
                                                @csrf
                                                <button type="submit" class="px-3 py-2 bg-emerald-600 text-white rounded-lg text-xs font-medium hover:bg-emerald-700" onclick="return confirm('Terima izin ini?')">Terima</button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.izin.reject', $r->id) }}">
                                                @csrf
                                                <button type="submit" class="px-3 py-2 bg-rose-600 text-white rounded-lg text-xs font-medium hover:bg-rose-700" onclick="return confirm('Tolak izin ini?')">Tolak</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">Tidak ada izin tidak masuk.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">{{ $requests->links() }}</div>
            </div>
        </div>
    </main>
</div>
</body>
</html>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payroll</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">
                @if (session('status'))
                    <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
                @endif

                <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-4">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2">
                            <option value="">Semua</option>
                            <option value="pending" @selected(request('status')==='pending')>Pending</option>
                            <option value="paid" @selected(request('status')==='paid')>Paid</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Tahun</label>
                        <input type="number" name="year" value="{{ $year }}" class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Bulan</label>
                        <input type="number" min="1" max="12" name="month" value="{{ $month }}" class="w-full border rounded px-3 py-2">
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
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Slip</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Bukti Transfer</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Dibayar</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($payrolls as $p)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $p->user->name }}</td>
                                    <td class="px-4 py-2 text-sm">{{ sprintf('%04d-%02d', $p->period_year, $p->period_month) }}</td>
                                    <td class="px-4 py-2 text-sm">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        <span class="px-2 py-1 rounded text-xs {{ $p->status==='paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ ucfirst($p->status) }}</span>
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if ($p->slip_pdf_path)
                                            <a href="{{ asset('storage/'.$p->slip_pdf_path) }}" target="_blank" class="text-indigo-600 hover:underline">Unduh</a>
                                        @else
                                            <form method="POST" action="{{ route('admin.payroll.generateSlip', $p->id) }}">
                                                @csrf
                                                <button class="px-3 py-1 rounded bg-gray-100 text-gray-700 text-xs">Generate</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">
                                        @if ($p->transfer_proof_path)
                                            <a href="{{ asset('storage/'.$p->transfer_proof_path) }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                                        @else
                                            <form method="POST" action="{{ route('admin.payroll.uploadProof', $p->id) }}" enctype="multipart/form-data" class="flex items-center gap-2">
                                                @csrf
                                                <input type="file" name="transfer_proof" class="text-xs">
                                                <button class="px-3 py-1 rounded bg-indigo-600 text-white text-xs">Unggah</button>
                                            </form>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">{{ $p->paid_at ? $p->paid_at->format('Y-m-d H:i') : '-' }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        @if ($p->status !== 'paid')
                                            <form method="POST" action="{{ route('admin.payroll.markPaid', $p->id) }}">
                                                @csrf
                                                <button class="px-3 py-1 rounded bg-emerald-600 text-white text-xs">Tandai Paid</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $payrolls->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>

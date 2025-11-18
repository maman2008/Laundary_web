<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Payroll</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">
                @if (session('status'))
                    <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.payroll.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Karyawan</label>
                        <select name="user_id" class="w-full border rounded px-3 py-2" required>
                            <option value="" disabled selected>Pilih karyawan</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}" @selected(old('user_id')==$u->id)>{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="text-sm text-rose-600 mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tahun</label>
                            <input type="number" name="period_year" value="{{ old('period_year', $currentYear) }}" class="w-full border rounded px-3 py-2" required>
                            @error('period_year')<div class="text-sm text-rose-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Bulan</label>
                            <input type="number" min="1" max="12" name="period_month" value="{{ old('period_month', $currentMonth) }}" class="w-full border rounded px-3 py-2" required>
                            @error('period_month')<div class="text-sm text-rose-600 mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Nominal (Rp)</label>
                        <input type="number" name="amount" min="0" value="{{ old('amount') }}" class="w-full border rounded px-3 py-2" required>
                        @error('amount')<div class="text-sm text-rose-600 mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Catatan (opsional)</label>
                        <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
                        @error('notes')<div class="text-sm text-rose-600 mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Bukti Transfer (opsional)</label>
                        <input type="file" name="transfer_proof" class="w-full border rounded px-3 py-2 text-sm">
                        @error('transfer_proof')<div class="text-sm text-rose-600 mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.payroll.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Batal</a>
                        <button class="px-4 py-2 bg-emerald-600 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-4 bg-white border rounded">
                    <div class="text-sm text-gray-600">Absensi Hari Ini</div>
                    <div class="mt-2 text-3xl font-bold">{{ $totalAttendancesToday }}</div>
                </div>
                <div class="p-4 bg-white border rounded">
                    <div class="text-sm text-gray-600">Telat Hari Ini</div>
                    <div class="mt-2 text-3xl font-bold text-amber-600">{{ $lateToday }}</div>
                </div>
                <div class="p-4 bg-white border rounded">
                    <div class="text-sm text-gray-600">Pengajuan Pending</div>
                    <div class="mt-2 text-3xl font-bold text-sky-600">{{ $pendingRequests }}</div>
                </div>
                <div class="p-4 bg-white border rounded">
                    <div class="text-sm text-gray-600">Payroll Pending</div>
                    <div class="mt-2 text-3xl font-bold text-emerald-600">{{ $pendingPayrolls }}</div>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.attendance.index') }}" class="block p-4 border rounded hover:bg-gray-50">
                    <div class="text-lg font-semibold">Absensi</div>
                    <div class="text-sm text-gray-600">Lihat rekap absensi karyawan</div>
                </a>
                <a href="{{ route('admin.requests.index') }}" class="block p-4 border rounded hover:bg-gray-50">
                    <div class="text-lg font-semibold">Pengajuan</div>
                    <div class="text-sm text-gray-600">Kelola pengajuan karyawan</div>
                </a>
                <a href="{{ route('admin.payroll.index') }}" class="block p-4 border rounded hover:bg-gray-50">
                    <div class="text-lg font-semibold">Gaji</div>
                    <div class="text-sm text-gray-600">Kelola payroll</div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('status'))
                        <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('status') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded bg-red-50 text-red-700 text-sm">
                            <ul class="list-disc ms-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('attendance.create') }}" class="block p-4 border rounded hover:bg-gray-50">
                            <div class="text-lg font-semibold">Absen Masuk</div>
                            <div class="text-sm text-gray-600">Ambil foto + lokasi</div>
                        </a>
                        <form method="POST" action="{{ route('attendance.checkout') }}" class="p-4 border rounded">
                            @csrf
                            <div class="text-lg font-semibold">Checkout</div>
                            <div class="text-sm text-gray-600 mb-3">Catat waktu pulang</div>
                            <x-primary-button>Checkout Sekarang</x-primary-button>
                        </form>
                        <a href="{{ route('requests.index') }}" class="block p-4 border rounded hover:bg-gray-50">
                            <div class="text-lg font-semibold">Pengajuan</div>
                            <div class="text-sm text-gray-600">Buat dan lihat pengajuan</div>
                        </a>
                        <a href="{{ route('payrolls.index') }}" class="block p-4 border rounded hover:bg-gray-50">
                            <div class="text-lg font-semibold">Gaji</div>
                            <div class="text-sm text-gray-600">Lihat slip dan bukti transfer</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

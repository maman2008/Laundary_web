<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Pengajuan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('requests.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="type" :value="__('Tipe Pengajuan')" />
                            <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="" disabled selected>Pilih tipe</option>
                                <option value="kerusakan_barang" @selected(old('type')==='kerusakan_barang')>Kerusakan Barang</option>
                                <option value="kekurangan_barang" @selected(old('type')==='kekurangan_barang')>Kekurangan Barang</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="title" :value="__('Judul')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        

                        <div>
                            <x-input-label for="attachment" :value="__('Lampiran (opsional)')" />
                            <input id="attachment" type="file" name="attachment" class="mt-1 block w-full text-sm text-gray-700" />
                            <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('requests.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">Batal</a>
                            <x-primary-button>
                                Simpan Pengajuan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

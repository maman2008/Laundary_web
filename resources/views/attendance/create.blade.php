<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Absen Kehadiran
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="attendance-form" method="POST" action="{{ route('attendance.store') }}">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kamera</label>
                                <div class="relative aspect-video bg-gray-100 rounded-md overflow-hidden">
                                    <video id="video" autoplay playsinline class="w-full h-full object-cover"></video>
                                    <canvas id="canvas" class="hidden"></canvas>
                                </div>
                                <div class="mt-3 flex items-center gap-2">
                                    <button type="button" id="capture-btn" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Ambil Foto</button>
                                    <span id="photo-status" class="text-sm text-gray-600"></span>
                                </div>
                                <input type="hidden" name="photo_data" id="photo_data">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                                <div class="p-3 bg-gray-50 rounded border border-gray-200">
                                    <div class="text-sm text-gray-700">
                                        <div>Latitude: <span id="lat-text">-</span></div>
                                        <div>Longitude: <span id="lng-text">-</span></div>
                                        <div class="mt-2 text-xs text-gray-500" id="loc-status">Meminta izin lokasi…</div>
                                    </div>
                                </div>
                                <input type="hidden" name="lat" id="lat">
                                <input type="hidden" name="lng" id="lng">
                                <div class="mt-3">
                                    <button type="button" id="refresh-loc" class="inline-flex items-center px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-xs text-gray-700 hover:bg-gray-200">Ambil Ulang Lokasi</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <x-primary-button id="submit-btn" disabled>
                                Simpan Absen
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('capture-btn');
        const photoInput = document.getElementById('photo_data');
        const photoStatus = document.getElementById('photo-status');
        const submitBtn = document.getElementById('submit-btn');

        const latEl = document.getElementById('lat');
        const lngEl = document.getElementById('lng');
        const latText = document.getElementById('lat-text');
        const lngText = document.getElementById('lng-text');
        const locStatus = document.getElementById('loc-status');
        const refreshLocBtn = document.getElementById('refresh-loc');

        let hasPhoto = false;
        let hasLocation = false;

        function updateSubmitState() {
            submitBtn.disabled = !(hasPhoto && hasLocation);
        }

        async function initCamera() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' }, audio: false });
                video.srcObject = stream;
            } catch (e) {
                photoStatus.textContent = 'Tidak dapat mengakses kamera: ' + e.message;
            }
        }

        function getLocation() {
            locStatus.textContent = 'Mengambil lokasi…';
            if (!navigator.geolocation) {
                locStatus.textContent = 'Geolocation tidak didukung browser.';
                return;
            }
            navigator.geolocation.getCurrentPosition((pos) => {
                const { latitude, longitude } = pos.coords;
                latEl.value = latitude;
                lngEl.value = longitude;
                latText.textContent = latitude.toFixed(6);
                lngText.textContent = longitude.toFixed(6);
                hasLocation = true;
                locStatus.textContent = 'Lokasi didapat.';
                updateSubmitState();
            }, (err) => {
                locStatus.textContent = 'Gagal ambil lokasi: ' + err.message;
                hasLocation = false;
                updateSubmitState();
            }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 });
        }

        captureBtn.addEventListener('click', () => {
            const width = video.videoWidth;
            const height = video.videoHeight;
            if (!width || !height) {
                photoStatus.textContent = 'Kamera belum siap.';
                return;
            }
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0, width, height);
            const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
            photoInput.value = dataUrl;
            hasPhoto = true;
            photoStatus.textContent = 'Foto siap diunggah.';
            updateSubmitState();
        });

        refreshLocBtn.addEventListener('click', getLocation);

        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible' && !video.srcObject) {
                initCamera();
            }
        });

        // init
        initCamera();
        getLocation();
    </script>
</x-app-layout>

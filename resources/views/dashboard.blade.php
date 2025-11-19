<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Karyawan - Laundry HR</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4361ee',
                        'primary-light': '#4895ef',
                        secondary: '#3f37c9',
                        success: '#4cc9f0',
                        warning: '#f72585',
                        info: '#7209b7',
                        dark: '#212529',
                        gray: {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px rgba(0, 0, 0, 0.08)',
                        'medium': '0 8px 25px rgba(0, 0, 0, 0.12)',
                    },
                    borderRadius: {
                        'xl': '12px',
                        '2xl': '16px',
                    }
                }
            }
        }
    </script>
    <style>
        .action-card {
            transition: all 0.3s ease;
        }
        .action-card:hover {
            transform: translateY(-3px);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-10 h-10 bg-white rounded-lg">
                            <i class="fas fa-tshirt text-primary text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold">Laundry HR</h1>
                            <p class="text-primary-light text-sm">Sistem Manajemen Karyawan</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="p-2 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors" aria-label="Notifikasi">
                                <i class="fas fa-bell"></i>
                            </button>
                            <span class="absolute top-0 right-0 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-warning opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-warning"></span>
                            </span>
                        </div>

                        @auth
                        <details class="relative group">
                            <summary class="list-none flex items-center space-x-2 bg-white/10 rounded-full pl-2 pr-3 py-1 backdrop-blur-sm cursor-pointer select-none">
                                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-primary font-medium">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium hidden sm:inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-white/80 ml-1"></i>
                            </summary>
                            <div class="absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-lg shadow-md py-1 z-10">
                                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Keluar</button>
                                </form>
                            </div>
                        </details>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Welcome Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Selamat Datang!</h2>
                    <p class="text-gray-600 mt-1">Kelola absensi dan pengajuan Anda dengan mudah</p>
                </div>

                <!-- Status Alert -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span class="font-medium">Terjadi kesalahan:</span>
                        </div>
                        <ul class="list-disc ms-5 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Absen Masuk -->
                    <a href="{{ route('attendance.create') }}" class="action-card block bg-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-medium transition-all group">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 text-white mr-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-camera text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Absen Masuk</h3>
                                <p class="text-sm text-gray-600 mt-1">Ambil foto + lokasi</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Mulai hari kerja Anda</span>
                            <span class="text-primary text-sm font-medium flex items-center">
                                Absen Sekarang
                                <i class="fas fa-arrow-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </div>
                    </a>

                    <!-- Checkout -->
                    <form method="POST" action="{{ route('attendance.checkout') }}" class="action-card bg-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-medium transition-all group">
                        @csrf
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white mr-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-sign-out-alt text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Checkout</h3>
                                <p class="text-sm text-gray-600 mt-1">Catat waktu pulang</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Akhiri hari kerja</span>
                            <button type="submit" class="bg-gradient-to-r from-orange-500 to-amber-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:shadow-md transition-shadow">
                                Checkout Sekarang
                            </button>
                        </div>
                    </form>

                    <!-- Pengajuan -->
                    <a href="{{ route('requests.index') }}" class="action-card block bg-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-medium transition-all group">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-500 text-white mr-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-file-alt text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Pengajuan</h3>
                                <p class="text-sm text-gray-600 mt-1">Buat dan lihat pengajuan</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Cuti, izin, dll</span>
                            <span class="text-primary text-sm font-medium flex items-center">
                                Kelola
                                <i class="fas fa-arrow-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </div>
                    </a>

                    <!-- Izin Tidak Masuk -->
                    <a href="{{ route('izin.create') }}" class="action-card block bg-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-medium transition-all group">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-rose-500 to-red-500 text-white mr-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-user-minus text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Izin Tidak Masuk</h3>
                                <p class="text-sm text-gray-600 mt-1">Ajukan sakit/pribadi/lainnya</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Form khusus izin</span>
                            <span class="text-primary text-sm font-medium flex items-center">
                                Ajukan
                                <i class="fas fa-arrow-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </div>
                    </a>

                    <!-- Gaji -->
                    <a href="{{ route('payrolls.index') }}" class="action-card block bg-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-medium transition-all group">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-purple-500 to-pink-500 text-white mr-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-money-bill-wave text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Gaji</h3>
                                <p class="text-sm text-gray-600 mt-1">Lihat slip dan bukti transfer</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-xs text-gray-500">Informasi gaji</span>
                            <span class="text-primary text-sm font-medium flex items-center">
                                Lihat
                                <i class="fas fa-arrow-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Today's Status -->
                <div class="bg-white rounded-2xl shadow-soft overflow-hidden mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Status Hari Ini</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center p-4 rounded-xl bg-blue-50 border border-blue-100">
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mx-auto mb-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900">Jam Masuk</h3>
                                <p class="text-2xl font-bold text-blue-600 mt-1">08:00</p>
                                <p class="text-xs text-gray-500 mt-1">Tepat waktu</p>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-green-50 border border-green-100">
                                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 mx-auto mb-3">
                                    <i class="fas fa-business-time"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900">Durasi Kerja</h3>
                                <p class="text-2xl font-bold text-green-600 mt-1">8j 30m</p>
                                <p class="text-xs text-gray-500 mt-1">Hari ini</p>
                            </div>
                            <div class="text-center p-4 rounded-xl bg-purple-50 border border-purple-100">
                                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 mx-auto mb-3">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <h3 class="font-semibold text-gray-900">Kehadiran</h3>
                                <p class="text-2xl font-bold text-purple-600 mt-1">24/30</p>
                                <p class="text-xs text-gray-500 mt-1">Bulan ini</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-soft overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <div class="px-6 py-4 flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fas fa-check"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">Absen masuk tercatat</p>
                                <p class="text-xs text-gray-500 mt-1">Hari ini pukul 08:00</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Selesai
                            </span>
                        </div>
                        <div class="px-6 py-4 flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">Pengajuan cuti diajukan</p>
                                <p class="text-xs text-gray-500 mt-1">Kemarin pukul 14:30</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Menunggu
                            </span>
                        </div>
                        <div class="px-6 py-4 flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">Slip gaji tersedia</p>
                                <p class="text-xs text-gray-500 mt-1">5 November 2023</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Baru
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
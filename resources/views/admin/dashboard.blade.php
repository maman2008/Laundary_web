<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Laundry HR</title>
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
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .action-card {
            transition: all 0.3s ease;
        }
        .action-card:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard Admin</h1>
                        <p class="text-sm text-gray-600 mt-1">Kelola karyawan laundry dengan mudah dan efisien</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors" aria-label="Notifikasi">
                                <i class="fas fa-bell"></i>
                            </button>
                            <span class="absolute top-0 right-0 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-warning opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-warning"></span>
                            </span>
                        </div>

                        @auth
                        <details class="relative group">
                            <summary class="list-none flex items-center space-x-2 bg-gray-100 rounded-full pl-2 pr-3 py-1 cursor-pointer select-none">
                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-medium">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium hidden sm:inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 ml-1"></i>
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
        <main class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Status Alert -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Absensi Hari Ini -->
                    <div class="stat-card bg-white rounded-2xl p-6 shadow-soft border-l-4 border-primary">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Absensi Hari Ini</p>
                                <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalAttendancesToday }}</h3>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-50 text-primary">
                                <i class="fas fa-user-check text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                            <span class="text-green-500 font-medium">12%</span>
                            <span class="ml-1">dari kemarin</span>
                        </div>
                    </div>

                    <!-- Telat Hari Ini -->
                    <div class="stat-card bg-white rounded-2xl p-6 shadow-soft border-l-4 border-amber-500">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Telat Hari Ini</p>
                                <h3 class="text-3xl font-bold text-amber-600 mt-2">{{ $lateToday }}</h3>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-50 text-amber-500">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-arrow-down text-green-500 mr-1"></i>
                            <span class="text-green-500 font-medium">5%</span>
                            <span class="ml-1">dari minggu lalu</span>
                        </div>
                    </div>

                    <!-- Pengajuan Pending -->
                    <div class="stat-card bg-white rounded-2xl p-6 shadow-soft border-l-4 border-sky-500">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pengajuan Pending</p>
                                <h3 class="text-3xl font-bold text-sky-600 mt-2">{{ $pendingRequests }}</h3>
                            </div>
                            <div class="p-3 rounded-xl bg-sky-50 text-sky-500">
                                <i class="fas fa-tasks text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-arrow-up text-amber-500 mr-1"></i>
                            <span class="text-amber-500 font-medium">2 baru</span>
                            <span class="ml-1">perlu ditinjau</span>
                        </div>
                    </div>

                    <!-- Payroll Pending -->
                    <div class="stat-card bg-white rounded-2xl p-6 shadow-soft border-l-4 border-emerald-500">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Payroll Pending</p>
                                <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $pendingPayrolls }}</h3>
                            </div>
                            <div class="p-3 rounded-xl bg-emerald-50 text-emerald-500">
                                <i class="fas fa-money-bill-wave text-lg"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-minus text-gray-400 mr-1"></i>
                            <span class="text-gray-400 font-medium">0%</span>
                            <span class="ml-1">dari bulan lalu</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Absensi -->
                    <a href="{{ route('admin.attendance.index') }}" class="action-card block bg-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-medium transition-all">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-primary to-primary-light text-white mr-4">
                                <i class="fas fa-clipboard-list text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Absensi</h3>
                        </div>
                        <p class="text-sm text-gray-600">Lihat rekap absensi karyawan</p>
                        <div class="mt-4 flex justify-end">
                            <span class="text-primary text-sm font-medium flex items-center">
                                Kelola
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </span>
                        </div>
                    </a>

                    <!-- Pengajuan -->
                    <a href="{{ route('admin.requests.index') }}" class="action-card block bg-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-medium transition-all">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-info to-purple-500 text-white mr-4">
                                <i class="fas fa-file-alt text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Pengajuan</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola pengajuan karyawan</p>
                        <div class="mt-4 flex justify-end">
                            <span class="text-primary text-sm font-medium flex items-center">
                                Kelola
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </span>
                        </div>
                    </a>

                    <!-- Gaji -->
                    <a href="{{ route('admin.payroll.index') }}" class="action-card block bg-white rounded-2xl p-6 shadow-soft border border-gray-100 hover:shadow-medium transition-all">
                        <div class="flex items-center mb-4">
                            <div class="p-3 rounded-xl bg-gradient-to-r from-success to-cyan-500 text-white mr-4">
                                <i class="fas fa-calculator text-lg"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Gaji</h3>
                        </div>
                        <p class="text-sm text-gray-600">Kelola payroll</p>
                        <div class="mt-4 flex justify-end">
                            <span class="text-primary text-sm font-medium flex items-center">
                                Kelola
                                <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Recent Activity Section -->
                <div class="mt-8 bg-white rounded-2xl shadow-soft overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Aktivitas Terbaru</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <!-- Activity Item 1 -->
                        <div class="px-6 py-4 flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">Andi Pratama terlambat absensi</p>
                                <p class="text-xs text-gray-500 mt-1">10 menit yang lalu</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                Perlu Tindakan
                            </span>
                        </div>

                        <!-- Activity Item 2 -->
                        <div class="px-6 py-4 flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">Sinta mengajukan cuti</p>
                                <p class="text-xs text-gray-500 mt-1">1 jam yang lalu</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Menunggu
                            </span>
                        </div>

                        <!-- Activity Item 3 -->
                        <div class="px-6 py-4 flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                                    <i class="fas fa-money-check"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">Payroll bulan November siap diproses</p>
                                <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Selesai
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
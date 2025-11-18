<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan - Laundry HR</title>
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
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                        info: '#3b82f6',
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
        .attendance-card {
            transition: all 0.3s ease;
        }
        .attendance-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
        }
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        /* Mobile optimizations */
        @media (max-width: 768px) {
            .mobile-card {
                border-radius: 12px;
                margin-bottom: 1rem;
                padding: 1rem;
            }
            .mobile-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center space-x-4">
                        <!-- Tombol Kembali -->
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 text-primary hover:text-secondary transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span class="hidden sm:inline">Kembali ke Dashboard</span>
                        </a>
                        <div class="h-6 border-l border-gray-300"></div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Absensi Karyawan</h1>
                            <p class="text-sm text-gray-600 mt-1">Pantau kehadiran dan ketepatan waktu karyawan</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition-colors">
                                <i class="fas fa-bell"></i>
                            </button>
                            <span class="absolute top-0 right-0 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-warning opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-warning"></span>
                            </span>
                        </div>
                        <div class="flex items-center space-x-2 bg-gray-100 rounded-full pl-2 pr-4 py-1">
                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-medium">A</div>
                            <span class="text-sm font-medium">Admin User</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Filter Section -->
                <div class="bg-white rounded-2xl p-6 shadow-soft mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Filter Absensi</h2>
                        <!-- Tombol Kembali Mobile -->
                        <a href="{{ route('admin.dashboard') }}" class="sm:hidden flex items-center space-x-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-calendar-day mr-2 text-primary"></i>
                                Tanggal
                            </label>
                            <input type="date" name="date" value="{{ $date }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                        <div class="flex items-center">
                            <label class="inline-flex items-center gap-3 cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" name="hanya_telat" value="1" {{ $hanyaTelat ? 'checked' : '' }} 
                                           class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                </div>
                                <span class="text-sm font-medium text-gray-700 flex items-center">
                                    <i class="fas fa-clock mr-2 text-amber-500"></i>
                                    Hanya Telat
                                </span>
                            </label>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="w-full px-4 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors flex items-center justify-center">
                                <i class="fas fa-filter mr-2"></i>
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Stats Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-primary">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Absensi</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $attendances->total() }}</h3>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-50 text-primary">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-emerald-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tepat Waktu</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-2">
                                    {{ $attendances->where('is_late', false)->count() }}
                                </h3>
                            </div>
                            <div class="p-3 rounded-xl bg-emerald-50 text-emerald-500">
                                <i class="fas fa-check-circle text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-amber-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Keterlambatan</p>
                                <h3 class="text-2xl font-bold text-amber-600 mt-2">
                                    {{ $attendances->where('is_late', true)->count() }}
                                </h3>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-50 text-amber-500">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden lg:block bg-white rounded-2xl shadow-soft overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">Daftar Absensi</h2>
                        <div class="text-sm text-gray-500">
                            Total: <span class="font-semibold">{{ $attendances->total() }}</span> absensi
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Karyawan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Check In</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Check Out</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Foto</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($attendances as $a)
                                    <tr class="attendance-card hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-medium text-sm mr-3">
                                                    {{ substr($a->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $a->user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($a->check_in_at)->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($a->check_in_at)->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($a->check_out_at)
                                                <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($a->check_out_at)->format('d M Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($a->check_out_at)->format('H:i') }}</div>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($a->photo_path)
                                                <div class="relative group">
                                                    <img src="{{ asset($a->photo_path) }}" alt="Foto absensi" 
                                                         class="h-12 w-12 object-cover rounded-lg cursor-pointer">
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all duration-200 flex items-center justify-center">
                                                        <i class="fas fa-search-plus text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-xs text-gray-500 font-mono">{{ $a->lat }}, {{ $a->lng }}</div>
                                            <button onclick="openMap({{ $a->lat }}, {{ $a->lng }})" 
                                                    class="text-xs text-primary hover:text-secondary mt-1 flex items-center">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                Lihat Peta
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($a->is_late)
                                                <span class="status-badge bg-amber-100 text-amber-700">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Telat
                                                </span>
                                            @else
                                                <span class="status-badge bg-emerald-100 text-emerald-700">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Tepat Waktu
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="fas fa-clipboard-list text-4xl mb-4"></i>
                                                <p class="text-lg font-medium text-gray-500">Tidak ada absensi</p>
                                                <p class="text-sm text-gray-400 mt-1">Tidak ada data absensi yang ditemukan dengan filter saat ini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $attendances->links() }}
                    </div>
                </div>

                <!-- Mobile Cards (shown on mobile) -->
                <div class="lg:hidden space-y-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-base font-semibold text-gray-900">Daftar Absensi</h2>
                        <div class="text-xs text-gray-500">
                            Total: <span class="font-semibold">{{ $attendances->total() }}</span>
                        </div>
                    </div>

                    @forelse ($attendances as $a)
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-medium text-sm">
                                    {{ substr($a->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $a->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($a->check_in_at)->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div>
                                @if($a->is_late)
                                    <span class="status-badge bg-amber-100 text-amber-700 text-xs">
                                        <i class="fas fa-clock mr-1"></i>
                                        Telat
                                    </span>
                                @else
                                    <span class="status-badge bg-emerald-100 text-emerald-700 text-xs">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Tepat Waktu
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mobile-grid">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Check In</span>
                                <div class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($a->check_in_at)->format('H:i') }}</div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Check Out</span>
                                <div class="text-sm text-gray-900">
                                    @if ($a->check_out_at)
                                        {{ \Carbon\Carbon::parse($a->check_out_at)->format('H:i') }}
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>

                            @if($a->photo_path)
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Foto</span>
                                <img src="{{ asset($a->photo_path) }}" alt="Foto absensi" 
                                     class="h-10 w-10 object-cover rounded-lg">
                            </div>
                            @endif

                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Lokasi</span>
                                <button onclick="openMap({{ $a->lat }}, {{ $a->lng }})" 
                                        class="text-xs text-primary hover:text-secondary flex items-center">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    Lihat Peta
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white mobile-card shadow-soft border border-gray-100 text-center py-8">
                        <i class="fas fa-clipboard-list text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm font-medium text-gray-500">Tidak ada absensi</p>
                        <p class="text-xs text-gray-400 mt-1">Tidak ada data absensi yang ditemukan</p>
                    </div>
                    @endforelse

                    <!-- Mobile Pagination -->
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        {{ $attendances->links() }}
                    </div>
                </div>

                <!-- Tombol Kembali di Bawah (opsional untuk mobile) -->
                <div class="mt-6 flex justify-center sm:hidden">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Function to open map location
        function openMap(lat, lng) {
            const url = `https://www.google.com/maps?q=${lat},${lng}`;
            window.open(url, '_blank');
        }

        // Add hover effects for images
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                img.addEventListener('click', function() {
                    // Create modal for image preview
                    const modal = document.createElement('div');
                    modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
                    modal.innerHTML = `
                        <div class="max-w-2xl max-h-full">
                            <img src="${this.src}" alt="Preview" class="max-w-full max-h-full object-contain">
                            <button class="absolute top-4 right-4 text-white text-2xl" onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    document.body.appendChild(modal);
                });
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin Tidak Masuk - Laundry HR</title>
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
        .izin-card {
            transition: all 0.3s ease;
        }
        .izin-card:hover {
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
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-primary hover:text-secondary transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span class="hidden sm:inline">Kembali ke Dashboard</span>
                        </a>
                        <div class="h-6 border-l border-gray-300"></div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Izin Tidak Masuk</h1>
                            <p class="text-sm text-gray-600 mt-1">Kelola pengajuan izin tidak masuk kerja</p>
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
                            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-medium">K</div>
                            <span class="text-sm font-medium">Karyawan User</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-6">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <!-- Status Alert -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Stats Summary -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-primary">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Izin</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $requests->total() }}</h3>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-50 text-primary">
                                <i class="fas fa-calendar-check text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-emerald-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Disetujui</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-2">
                                    {{ $requests->where('status', 'accepted')->count() }}
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
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Pending</p>
                                <h3 class="text-2xl font-bold text-amber-600 mt-2">
                                    {{ $requests->where('status', 'pending')->count() }}
                                </h3>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-50 text-amber-500">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-rose-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Ditolak</p>
                                <h3 class="text-2xl font-bold text-rose-600 mt-2">
                                    {{ $requests->where('status', 'rejected')->count() }}
                                </h3>
                            </div>
                            <div class="p-3 rounded-xl bg-rose-50 text-rose-500">
                                <i class="fas fa-times-circle text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Header -->
                <div class="bg-white rounded-2xl p-6 shadow-soft mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Riwayat Pengajuan Izin</h2>
                            <p class="text-sm text-gray-600 mt-1">Filter berdasarkan status pengajuan</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <!-- Tombol Kembali Mobile -->
                            <a href="{{ route('dashboard') }}" class="sm:hidden flex items-center justify-center space-x-2 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                            <a href="{{ route('izin.create') }}" class="flex items-center justify-center space-x-2 px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors shadow-md hover:shadow-lg">
                                <i class="fas fa-plus-circle mr-2"></i>
                                <span>Ajukan Izin Baru</span>
                            </a>
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        @php($active = $status ?? '')
                        <a href="{{ route('izin.index') }}" class="flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $active==='' ? 'bg-primary text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                            <i class="fas fa-list mr-2"></i>
                            Semua
                        </a>
                        <a href="{{ route('izin.index', ['status' => 'pending']) }}" class="flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $active==='pending' ? 'bg-amber-500 text-white shadow-md' : 'bg-amber-50 text-amber-600 hover:bg-amber-100' }}">
                            <i class="fas fa-clock mr-2"></i>
                            Pending
                        </a>
                        <a href="{{ route('izin.index', ['status' => 'accepted']) }}" class="flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $active==='accepted' ? 'bg-emerald-500 text-white shadow-md' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }}">
                            <i class="fas fa-check-circle mr-2"></i>
                            Disetujui
                        </a>
                        <a href="{{ route('izin.index', ['status' => 'rejected']) }}" class="flex items-center px-4 py-2 rounded-xl text-sm font-medium transition-all {{ $active==='rejected' ? 'bg-rose-500 text-white shadow-md' : 'bg-rose-50 text-rose-600 hover:bg-rose-100' }}">
                            <i class="fas fa-times-circle mr-2"></i>
                            Ditolak
                        </a>
                    </div>
                </div>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden lg:block bg-white rounded-2xl shadow-soft overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Pengajuan Izin</h3>
                    </div>

                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Dibuat</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Izin</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lampiran</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($requests as $r)
                                    <tr class="izin-card hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $r->created_at?->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $r->created_at?->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }}
                                                @if($r->start_date != $r->end_date)
                                                <span class="text-gray-400 mx-1">s/d</span>
                                                {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $r->start_date }} @if($r->start_date != $r->end_date)s/d {{ $r->end_date }}@endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 max-w-xs">
                                            @if ($r->description)
                                                <div class="text-sm text-gray-700 line-clamp-2">{{ $r->description }}</div>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($r->status === 'accepted')
                                                <span class="status-badge bg-emerald-100 text-emerald-700">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Disetujui
                                                </span>
                                            @elseif($r->status === 'rejected')
                                                <span class="status-badge bg-rose-100 text-rose-700">
                                                    <i class="fas fa-times-circle mr-1"></i>
                                                    Ditolak
                                                </span>
                                            @else
                                                <span class="status-badge bg-amber-100 text-amber-700">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($r->attachment_path)
                                                <a href="{{ asset('storage/'.$r->attachment_path) }}" target="_blank" 
                                                   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 hover:bg-purple-200 transition-colors">
                                                    <i class="fas fa-paperclip mr-1"></i>
                                                    Lihat File
                                                </a>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="fas fa-calendar-times text-4xl mb-4"></i>
                                                <p class="text-lg font-medium text-gray-500">Belum ada pengajuan izin</p>
                                                <p class="text-sm text-gray-400 mt-1">Mulai dengan mengajukan izin pertama Anda</p>
                                                <a href="{{ route('izin.create') }}" class="mt-4 flex items-center space-x-2 px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Ajukan Izin</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($requests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $requests->links() }}
                    </div>
                    @endif
                </div>

                <!-- Mobile Cards (shown on mobile) -->
                <div class="lg:hidden space-y-4">
                    @forelse ($requests as $r)
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }}
                                    @if($r->start_date != $r->end_date)
                                    <span class="text-gray-400 mx-1">s/d</span>
                                    {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Diajukan: {{ $r->created_at?->format('d M Y H:i') }}</div>
                            </div>
                            <div>
                                @if($r->status === 'accepted')
                                    <span class="status-badge bg-emerald-100 text-emerald-700 text-xs">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Disetujui
                                    </span>
                                @elseif($r->status === 'rejected')
                                    <span class="status-badge bg-rose-100 text-rose-700 text-xs">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="status-badge bg-amber-100 text-amber-700 text-xs">
                                        <i class="fas fa-clock mr-1"></i>
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mobile-grid">
                            @if ($r->description)
                            <div>
                                <span class="text-xs text-gray-500">Keterangan</span>
                                <div class="text-sm text-gray-700 mt-1 line-clamp-2">{{ $r->description }}</div>
                            </div>
                            @endif

                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Lampiran</span>
                                <div>
                                    @if ($r->attachment_path)
                                        <a href="{{ asset('storage/'.$r->attachment_path) }}" target="_blank" 
                                           class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="fas fa-paperclip mr-1"></i>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white mobile-card shadow-soft border border-gray-100 text-center py-8">
                        <i class="fas fa-calendar-times text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm font-medium text-gray-500">Belum ada pengajuan izin</p>
                        <p class="text-xs text-gray-400 mt-1">Mulai dengan mengajukan izin pertama Anda</p>
                        <a href="{{ route('izin.create') }}" class="mt-4 inline-flex items-center space-x-2 px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors">
                            <i class="fas fa-plus-circle"></i>
                            <span>Ajukan Izin</span>
                        </a>
                    </div>
                    @endforelse

                    <!-- Mobile Pagination -->
                    @if($requests->hasPages())
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        {{ $requests->links() }}
                    </div>
                    @endif
                </div>

                <!-- Info Card -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 text-lg mt-0.5"></i>
                        <div>
                            <h3 class="font-semibold text-blue-800 text-sm">Informasi Pengajuan Izin</h3>
                            <ul class="mt-2 text-xs text-blue-700 space-y-1">
                                <li>• Ajukan izin minimal 1 hari sebelum tanggal yang dimaksud</li>
                                <li>• Lampirkan dokumen pendukung (surat dokter, dll) jika ada</li>
                                <li>• Status "Pending" menunggu persetujuan dari atasan</li>
                                <li>• Untuk izin mendadak, hubungi langsung supervisor</li>
                                <li>• Pastikan keterangan izin jelas dan lengkap</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tombol Kembali di Bawah (opsional untuk mobile) -->
                <div class="mt-6 flex justify-center sm:hidden">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Add any interactive functionality if needed
        document.addEventListener('DOMContentLoaded', function() {
            // You can add any JavaScript functionality here
            // For example, tooltips, modals, etc.
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Gaji - Laundry HR</title>
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
        .payroll-card {
            transition: all 0.3s ease;
        }
        .payroll-card:hover {
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
                            <h1 class="text-2xl font-bold text-gray-900">Riwayat Gaji</h1>
                            <p class="text-sm text-gray-600 mt-1">Lihat sejarah pembayaran gaji Anda</p>
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
                <!-- Stats Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-primary">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Periode</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-2">{{ $payrolls->total() }}</h3>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-50 text-primary">
                                <i class="fas fa-calendar-alt text-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-soft border-l-4 border-emerald-500">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Sudah Dibayar</p>
                                <h3 class="text-2xl font-bold text-gray-900 mt-2">
                                    {{ $payrolls->where('status', 'paid')->count() }}
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
                                <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Menunggu</p>
                                <h3 class="text-2xl font-bold text-amber-600 mt-2">
                                    {{ $payrolls->where('status', 'pending')->count() }}
                                </h3>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-50 text-amber-500">
                                <i class="fas fa-clock text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Header -->
                <div class="bg-white rounded-2xl p-6 shadow-soft mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Riwayat Pembayaran Gaji</h2>
                            <p class="text-sm text-gray-600 mt-1">Detail semua periode gaji yang tercatat</p>
                        </div>
                        <!-- Tombol Kembali Mobile -->
                        <a href="{{ route('dashboard') }}" class="sm:hidden flex items-center justify-center space-x-2 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden lg:block bg-white rounded-2xl shadow-soft overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Daftar Gaji</h3>
                    </div>

                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nominal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bukti Transfer</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($payrolls as $p)
                                    <tr class="payroll-card hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::create($p->period_year, $p->period_month)->translatedFormat('F Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ sprintf('%04d-%02d', $p->period_year, $p->period_month) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($p->status === 'paid')
                                                <span class="status-badge bg-emerald-100 text-emerald-700">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Dibayar
                                                </span>
                                            @else
                                                <span class="status-badge bg-amber-100 text-amber-700">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($p->amount, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($p->transfer_proof_path)
                                                <a href="{{ asset('storage/'.$p->transfer_proof_path) }}" target="_blank" 
                                                   class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 hover:bg-purple-200 transition-colors">
                                                    <i class="fas fa-file-invoice mr-1"></i>
                                                    Lihat Bukti
                                                </a>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($p->paid_at)
                                                <div class="text-sm text-gray-900">{{ $p->paid_at->format('d M Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $p->paid_at->format('H:i') }}</div>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="fas fa-money-bill-wave text-4xl mb-4"></i>
                                                <p class="text-lg font-medium text-gray-500">Belum ada data gaji</p>
                                                <p class="text-sm text-gray-400 mt-1">Data gaji akan muncul setelah payroll diproses</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($payrolls->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $payrolls->links() }}
                    </div>
                    @endif
                </div>

                <!-- Mobile Cards (shown on mobile) -->
                <div class="lg:hidden space-y-4">
                    @forelse ($payrolls as $p)
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::create($p->period_year, $p->period_month)->translatedFormat('F Y') }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">{{ sprintf('%04d-%02d', $p->period_year, $p->period_month) }}</div>
                            </div>
                            <div>
                                @if($p->status === 'paid')
                                    <span class="status-badge bg-emerald-100 text-emerald-700 text-xs">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Dibayar
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
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Nominal</span>
                                <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($p->amount, 0, ',', '.') }}</div>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Bukti Transfer</span>
                                <div>
                                    @if ($p->transfer_proof_path)
                                        <a href="{{ asset('storage/'.$p->transfer_proof_path) }}" target="_blank" 
                                           class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="fas fa-file-invoice mr-1"></i>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>

                            @if ($p->paid_at)
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Dibayar</span>
                                <div class="text-xs text-gray-900 text-right">
                                    {{ $p->paid_at->format('d M Y H:i') }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-white mobile-card shadow-soft border border-gray-100 text-center py-8">
                        <i class="fas fa-money-bill-wave text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm font-medium text-gray-500">Belum ada data gaji</p>
                        <p class="text-xs text-gray-400 mt-1">Data gaji akan muncul setelah payroll diproses</p>
                    </div>
                    @endforelse

                    <!-- Mobile Pagination -->
                    @if($payrolls->hasPages())
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        {{ $payrolls->links() }}
                    </div>
                    @endif
                </div>

                <!-- Info Card -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 text-lg mt-0.5"></i>
                        <div>
                            <h3 class="font-semibold text-blue-800 text-sm">Informasi Gaji</h3>
                            <ul class="mt-2 text-xs text-blue-700 space-y-1">
                                <li>• Gaji biasanya diproses pada akhir setiap bulan</li>
                                <li>• Status "Dibayar" menandakan gaji sudah ditransfer</li>
                                <li>• Bukti transfer dapat dilihat untuk verifikasi</li>
                                <li>• Untuk pertanyaan tentang gaji, hubungi bagian HRD</li>
                                <li>• Pastikan data bank Anda sudah benar dan aktif</li>
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
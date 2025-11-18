<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll - Laundry HR</title>
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
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 text-primary hover:text-secondary transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span class="hidden sm:inline">Kembali ke Dashboard</span>
                        </a>
                        <div class="h-6 border-l border-gray-300"></div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Payroll</h1>
                            <p class="text-sm text-gray-600 mt-1">Kelola gaji dan pembayaran karyawan</p>
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
                <!-- Status Alert -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="bg-white rounded-2xl p-6 shadow-soft mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Filter Payroll</h2>
                        <!-- Tombol Kembali Mobile -->
                        <a href="{{ route('admin.dashboard') }}" class="sm:hidden flex items-center space-x-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                                <option value="">Semua Status</option>
                                <option value="pending" @selected(request('status')==='pending')>Pending</option>
                                <option value="paid" @selected(request('status')==='paid')>Paid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <input type="number" name="year" value="{{ $year }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                            <input type="number" min="1" max="12" name="month" value="{{ $month }}" class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="w-full px-4 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors flex items-center justify-center">
                                <i class="fas fa-filter mr-2"></i>
                                Filter
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('admin.payroll.create') }}" class="w-full flex items-center justify-center px-4 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Payroll
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden lg:block bg-white rounded-2xl shadow-soft overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-900">Daftar Payroll</h2>
                        <div class="text-sm text-gray-500">
                            Total: <span class="font-semibold">{{ $payrolls->total() }}</span> payroll
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Karyawan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nominal</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Bukti Transfer</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Dibayar</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($payrolls as $p)
                                    <tr class="payroll-card hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-medium text-sm mr-3">
                                                    {{ substr($p->user->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $p->user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::create($p->period_year, $p->period_month)->translatedFormat('F Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ sprintf('%04d-%02d', $p->period_year, $p->period_month) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900">Rp {{ number_format($p->amount, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($p->status === 'paid')
                                                <span class="status-badge bg-emerald-100 text-emerald-700">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Paid
                                                </span>
                                            @else
                                                <span class="status-badge bg-amber-100 text-amber-700">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($p->transfer_proof_path)
                                                <a href="{{ asset('storage/'.$p->transfer_proof_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 hover:bg-purple-200 transition-colors">
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if ($p->status !== 'paid')
                                                <form method="POST" action="{{ route('admin.payroll.markPaid', $p->id) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-emerald-600 text-white rounded-lg text-xs font-medium hover:bg-emerald-700 transition-colors" onclick="return confirm('Tandai payroll ini sebagai paid?')">
                                                        <i class="fas fa-check mr-1"></i>
                                                        Tandai Paid
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 text-sm">Sudah dibayar</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="fas fa-money-bill-wave text-4xl mb-4"></i>
                                                <p class="text-lg font-medium text-gray-500">Tidak ada payroll</p>
                                                <p class="text-sm text-gray-400 mt-1">Tidak ada payroll yang ditemukan dengan filter saat ini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $payrolls->links() }}
                    </div>
                </div>

                <!-- Mobile Cards (shown on mobile) -->
                <div class="lg:hidden space-y-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-base font-semibold text-gray-900">Daftar Payroll</h2>
                        <div class="text-xs text-gray-500">
                            Total: <span class="font-semibold">{{ $payrolls->total() }}</span>
                        </div>
                    </div>

                    @forelse ($payrolls as $p)
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-medium text-sm">
                                    {{ substr($p->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $p->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ sprintf('%04d-%02d', $p->period_year, $p->period_month) }}</div>
                                </div>
                            </div>
                            <div>
                                @if($p->status === 'paid')
                                    <span class="status-badge bg-emerald-100 text-emerald-700 text-xs">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Paid
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
                                <span class="text-xs text-gray-500">Periode</span>
                                <div class="text-sm text-gray-900 text-right">
                                    {{ \Carbon\Carbon::create($p->period_year, $p->period_month)->translatedFormat('F Y') }}
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Bukti Transfer</span>
                                <div>
                                    @if ($p->transfer_proof_path)
                                        <a href="{{ asset('storage/'.$p->transfer_proof_path) }}" target="_blank" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
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

                        <!-- Actions -->
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            @if ($p->status !== 'paid')
                                <form method="POST" action="{{ route('admin.payroll.markPaid', $p->id) }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center px-3 py-2 bg-emerald-600 text-white rounded-lg text-xs font-medium hover:bg-emerald-700 transition-colors" onclick="return confirm('Tandai payroll ini sebagai paid?')">
                                        <i class="fas fa-check mr-2"></i>
                                        Tandai Sebagai Paid
                                    </button>
                                </form>
                            @else
                                <div class="text-center text-xs text-gray-500 py-2">
                                    Sudah dibayar
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-white mobile-card shadow-soft border border-gray-100 text-center py-8">
                        <i class="fas fa-money-bill-wave text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm font-medium text-gray-500">Tidak ada payroll</p>
                        <p class="text-xs text-gray-400 mt-1">Tidak ada payroll yang ditemukan</p>
                    </div>
                    @endforelse

                    <!-- Mobile Pagination -->
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        {{ $payrolls->links() }}
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
        // Add confirmation for actions
        document.addEventListener('DOMContentLoaded', function() {
            const actionButtons = document.querySelectorAll('form button');
            actionButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin melanjutkan?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
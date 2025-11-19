<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Saya - Laundry HR</title>
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
        .request-card {
            transition: all 0.3s ease;
        }
        .request-card:hover {
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
                            <h1 class="text-2xl font-bold text-gray-900">Daftar Pengajuan Saya</h1>
                            <p class="text-sm text-gray-600 mt-1">Kelola semua pengajuan yang telah Anda buat</p>
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

                <!-- Action Header -->
                <div class="bg-white rounded-2xl p-6 shadow-soft mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Pengajuan Saya</h2>
                            <p class="text-sm text-gray-600 mt-1">Total {{ $requests->total() }} pengajuan</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <!-- Tombol Kembali Mobile -->
                            <a href="{{ route('dashboard') }}" class="sm:hidden flex items-center justify-center space-x-2 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                            <a href="{{ route('requests.create') }}" class="flex items-center justify-center space-x-2 px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors shadow-md hover:shadow-lg">
                                <i class="fas fa-plus-circle"></i>
                                <span>Buat Pengajuan Baru</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table (hidden on mobile) -->
                <div class="hidden lg:block bg-white rounded-2xl shadow-soft overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Riwayat Pengajuan</h3>
                    </div>

                    <div class="table-container">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lampiran</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($requests as $req)
                                    <tr class="request-card hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $req->created_at->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-500">{{ $req->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ ucwords(str_replace('_',' ', $req->type)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $req->title }}</div>
                                            @if($req->description)
                                            <div class="text-xs text-gray-500 mt-1 truncate max-w-xs">{{ Str::limit($req->description, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($req->status === 'accepted')
                                                <span class="status-badge bg-emerald-100 text-emerald-700">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Diterima
                                                </span>
                                            @elseif($req->status === 'rejected')
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
                                            @if ($req->attachment_path)
                                                <a href="{{ asset('storage/'.$req->attachment_path) }}" target="_blank" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 hover:bg-purple-200 transition-colors">
                                                    <i class="fas fa-paperclip mr-1"></i>
                                                    Lihat File
                                                </a>
                                            @else
                                                <span class="text-sm text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                @if($req->status === 'pending')
                                                <a href="{{ route('requests.edit', $req->id) }}" class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg text-xs font-medium hover:bg-secondary transition-colors">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('requests.destroy', $req->id) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-2 bg-rose-600 text-white rounded-lg text-xs font-medium hover:bg-rose-700 transition-colors" onclick="return confirm('Hapus pengajuan ini?')">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                                @else
                                                <span class="text-gray-400 text-sm">Tidak dapat diubah</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <i class="fas fa-inbox text-4xl mb-4"></i>
                                                <p class="text-lg font-medium text-gray-500">Belum ada pengajuan</p>
                                                <p class="text-sm text-gray-400 mt-1">Mulai dengan membuat pengajuan pertama Anda</p>
                                                <a href="{{ route('requests.create') }}" class="mt-4 flex items-center space-x-2 px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors">
                                                    <i class="fas fa-plus-circle"></i>
                                                    <span>Buat Pengajuan</span>
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
                    @forelse ($requests as $req)
                    <div class="bg-white mobile-card shadow-soft border border-gray-100">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $req->title }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $req->created_at->format('d M Y H:i') }}</div>
                            </div>
                            <div>
                                @if($req->status === 'accepted')
                                    <span class="status-badge bg-emerald-100 text-emerald-700 text-xs">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Diterima
                                    </span>
                                @elseif($req->status === 'rejected')
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
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Tipe</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucwords(str_replace('_',' ', $req->type)) }}
                                </span>
                            </div>
                            
                            @if($req->description)
                            <div>
                                <span class="text-xs text-gray-500">Deskripsi</span>
                                <div class="text-sm text-gray-700 mt-1 line-clamp-2">{{ $req->description }}</div>
                            </div>
                            @endif

                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Lampiran</span>
                                <div>
                                    @if ($req->attachment_path)
                                        <a href="{{ asset('storage/'.$req->attachment_path) }}" target="_blank" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            <i class="fas fa-paperclip mr-1"></i>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            @if($req->status === 'pending')
                                <div class="flex space-x-2">
                                    <a href="{{ route('requests.edit', $req->id) }}" class="flex-1 flex items-center justify-center px-3 py-2 bg-primary text-white rounded-lg text-xs font-medium hover:bg-secondary transition-colors">
                                        <i class="fas fa-edit mr-2"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('requests.destroy', $req->id) }}" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full flex items-center justify-center px-3 py-2 bg-rose-600 text-white rounded-lg text-xs font-medium hover:bg-rose-700 transition-colors" onclick="return confirm('Hapus pengajuan ini?')">
                                            <i class="fas fa-trash mr-2"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="text-center text-xs text-gray-500 py-2">
                                    Pengajuan sudah diproses, tidak dapat diubah
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-white mobile-card shadow-soft border border-gray-100 text-center py-8">
                        <i class="fas fa-inbox text-3xl text-gray-300 mb-3"></i>
                        <p class="text-sm font-medium text-gray-500">Belum ada pengajuan</p>
                        <p class="text-xs text-gray-400 mt-1">Mulai dengan membuat pengajuan pertama Anda</p>
                        <a href="{{ route('requests.create') }}" class="mt-4 inline-flex items-center space-x-2 px-6 py-3 bg-primary text-white rounded-xl font-medium hover:bg-secondary transition-colors">
                            <i class="fas fa-plus-circle"></i>
                            <span>Buat Pengajuan</span>
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
        // Add confirmation for delete actions
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('form button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>
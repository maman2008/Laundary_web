<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Payroll - Laundry HR</title>
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
        .form-card {
            transition: all 0.3s ease;
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.15);
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
                        <a href="{{ route('admin.payroll.index') }}" class="flex items-center space-x-2 text-primary hover:text-secondary transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span class="hidden sm:inline">Kembali ke Payroll</span>
                        </a>
                        <div class="h-6 border-l border-gray-300"></div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Tambah Payroll</h1>
                            <p class="text-sm text-gray-600 mt-1">Buat payroll baru untuk karyawan</p>
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
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <!-- Status Alert -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-500"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-soft overflow-hidden form-card">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary to-primary-light">
                        <h2 class="text-lg font-semibold text-white">Form Tambah Payroll</h2>
                        <p class="text-primary-light text-sm mt-1">Isi data payroll dengan lengkap dan benar</p>
                    </div>

                    <form method="POST" action="{{ route('admin.payroll.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf

                        <!-- Karyawan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-user mr-2 text-primary"></i>
                                Karyawan
                                <span class="text-rose-500 ml-1">*</span>
                            </label>
                            <select name="user_id" class="w-full border border-gray-300 rounded-xl px-4 py-3 form-input focus:ring-2 focus:ring-primary focus:border-primary transition-all" required>
                                <option value="" disabled selected class="text-gray-400">Pilih karyawan</option>
                                @foreach ($users as $u)
                                    <option value="{{ $u->id }}" @selected(old('user_id')==$u->id) class="text-gray-700">{{ $u->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="flex items-center mt-2 text-sm text-rose-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Periode -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                    Tahun
                                    <span class="text-rose-500 ml-1">*</span>
                                </label>
                                <input type="number" name="period_year" value="{{ old('period_year', $currentYear) }}" 
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 form-input focus:ring-2 focus:ring-primary focus:border-primary transition-all" 
                                       required>
                                @error('period_year')
                                    <div class="flex items-center mt-2 text-sm text-rose-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-calendar mr-2 text-primary"></i>
                                    Bulan
                                    <span class="text-rose-500 ml-1">*</span>
                                </label>
                                <input type="number" min="1" max="12" name="period_month" value="{{ old('period_month', $currentMonth) }}" 
                                       class="w-full border border-gray-300 rounded-xl px-4 py-3 form-input focus:ring-2 focus:ring-primary focus:border-primary transition-all" 
                                       required>
                                @error('period_month')
                                    <div class="flex items-center mt-2 text-sm text-rose-600">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nominal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-money-bill-wave mr-2 text-primary"></i>
                                Nominal (Rp)
                                <span class="text-rose-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                <input type="number" name="amount" min="0" value="{{ old('amount') }}" 
                                       class="w-full border border-gray-300 rounded-xl pl-12 pr-4 py-3 form-input focus:ring-2 focus:ring-primary focus:border-primary transition-all" 
                                       placeholder="0" required>
                            </div>
                            @error('amount')
                                <div class="flex items-center mt-2 text-sm text-rose-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-sticky-note mr-2 text-primary"></i>
                                Catatan (opsional)
                            </label>
                            <textarea name="notes" rows="4" 
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 form-input focus:ring-2 focus:ring-primary focus:border-primary transition-all resize-none"
                                      placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="flex items-center mt-2 text-sm text-rose-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Bukti Transfer -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-file-upload mr-2 text-primary"></i>
                                Bukti Transfer (opsional)
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary transition-colors">
                                <input type="file" name="transfer_proof" 
                                       class="hidden" id="fileInput">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Klik untuk upload bukti transfer</p>
                                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, PDF (max. 5MB)</p>
                                    </div>
                                    <button type="button" onclick="document.getElementById('fileInput').click()" 
                                            class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
                                        <i class="fas fa-folder-open mr-2"></i>
                                        Pilih File
                                    </button>
                                </div>
                                <div id="fileName" class="mt-3 text-sm text-gray-600 hidden"></div>
                            </div>
                            @error('transfer_proof')
                                <div class="flex items-center mt-2 text-sm text-rose-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            <!-- Tombol Kembali Mobile -->
                            <a href="{{ route('admin.payroll.index') }}" class="sm:hidden w-full flex items-center justify-center space-x-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                            
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <!-- Tombol Kembali Desktop -->
                                <a href="{{ route('admin.payroll.index') }}" class="hidden sm:flex items-center space-x-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Kembali</span>
                                </a>
                                <button type="submit" class="flex-1 sm:flex-none flex items-center justify-center space-x-2 px-6 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan Payroll</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Info Card -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 text-lg mt-0.5"></i>
                        <div>
                            <h3 class="font-semibold text-blue-800 text-sm">Informasi Penting</h3>
                            <ul class="mt-2 text-xs text-blue-700 space-y-1">
                                <li>• Pastikan data karyawan dan nominal sudah benar</li>
                                <li>• Periode payroll harus sesuai dengan bulan dan tahun yang dimaksud</li>
                                <li>• Bukti transfer dapat diupload setelah pembayaran dilakukan</li>
                                <li>• Status payroll akan otomatis menjadi "Pending" setelah dibuat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // File input handler
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const fileName = document.getElementById('fileName');
            if (this.files.length > 0) {
                fileName.textContent = 'File terpilih: ' + this.files[0].name;
                fileName.classList.remove('hidden');
            } else {
                fileName.classList.add('hidden');
            }
        });

        // Form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input[required], select[required]');
            
            inputs.forEach(input => {
                input.addEventListener('invalid', function(e) {
                    e.preventDefault();
                    this.classList.add('border-rose-500');
                    
                    // Show custom error message
                    const errorDiv = this.parentElement.querySelector('.text-rose-600') || 
                                   this.nextElementSibling;
                    if (errorDiv) {
                        errorDiv.classList.remove('hidden');
                    }
                });
                
                input.addEventListener('input', function() {
                    this.classList.remove('border-rose-500');
                    const errorDiv = this.parentElement.querySelector('.text-rose-600') || 
                                   this.nextElementSibling;
                    if (errorDiv) {
                        errorDiv.classList.add('hidden');
                    }
                });
            });
        });

        // Format nominal input
        const amountInput = document.querySelector('input[name="amount"]');
        amountInput.addEventListener('input', function(e) {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
</body>
</html>
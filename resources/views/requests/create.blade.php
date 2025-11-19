<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengajuan - Laundry HR</title>
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
        .file-upload-area {
            transition: all 0.3s ease;
        }
        .file-upload-area.dragover {
            border-color: #4361ee;
            background-color: #f0f4ff;
            transform: translateY(-2px);
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
                        <a href="{{ route('requests.index') }}" class="flex items-center space-x-2 text-primary hover:text-secondary transition-colors">
                            <i class="fas fa-arrow-left"></i>
                            <span class="hidden sm:inline">Kembali ke Daftar Pengajuan</span>
                        </a>
                        <div class="h-6 border-l border-gray-300"></div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Buat Pengajuan</h1>
                            <p class="text-sm text-gray-600 mt-1">Ajukan permohonan untuk kerusakan atau kekurangan barang</p>
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
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-soft overflow-hidden form-card">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary to-primary-light">
                        <h2 class="text-lg font-semibold text-white">Form Pengajuan Baru</h2>
                        <p class="text-primary-light text-sm mt-1">Isi form dengan data yang lengkap dan benar</p>
                    </div>

                    <form method="POST" action="{{ route('requests.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf

                        <!-- Tipe Pengajuan -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-tag mr-2 text-primary"></i>
                                Tipe Pengajuan
                                <span class="text-rose-500 ml-1">*</span>
                            </label>
                            <select id="type" name="type" class="w-full border border-gray-300 rounded-xl px-4 py-3 form-input focus:ring-2 focus:ring-primary focus:border-primary transition-all" required>
                                <option value="" disabled selected class="text-gray-400">Pilih tipe pengajuan</option>
                                <option value="kerusakan_barang" @selected(old('type')==='kerusakan_barang') class="text-gray-700">Kerusakan Barang</option>
                                <option value="kekurangan_barang" @selected(old('type')==='kekurangan_barang') class="text-gray-700">Kekurangan Barang</option>
                            </select>
                            @error('type')
                                <div class="flex items-center mt-2 text-sm text-rose-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Judul -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-heading mr-2 text-primary"></i>
                                Judul Pengajuan
                                <span class="text-rose-500 ml-1">*</span>
                            </label>
                            <input id="title" name="title" type="text" value="{{ old('title') }}" 
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 form-input focus:ring-2 focus:ring-primary focus:border-primary transition-all" 
                                   placeholder="Masukkan judul pengajuan yang jelas dan deskriptif" required>
                            @error('title')
                                <div class="flex items-center mt-2 text-sm text-rose-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-align-left mr-2 text-primary"></i>
                                Deskripsi Lengkap
                            </label>
                            <textarea id="description" name="description" rows="5" 
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 form-input focus:ring-2 focus:ring-primary focus:border-primary transition-all resize-none"
                                      placeholder="Jelaskan secara detail mengenai pengajuan Anda...">{{ old('description') }}</textarea>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs text-gray-500">Deskripsi yang jelas akan mempermudah proses verifikasi</span>
                                <span id="charCount" class="text-xs text-gray-400">0 karakter</span>
                            </div>
                            @error('description')
                                <div class="flex items-center mt-2 text-sm text-rose-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Lampiran -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <i class="fas fa-paperclip mr-2 text-primary"></i>
                                Lampiran (Opsional)
                            </label>
                            <div class="file-upload-area border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary transition-all cursor-pointer"
                                 id="fileUploadArea">
                                <input type="file" id="attachment" name="attachment" class="hidden">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                    <div>
                                        <p class="text-sm text-gray-600">Klik untuk upload lampiran</p>
                                        <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG (max. 5MB)</p>
                                    </div>
                                    <button type="button" onclick="document.getElementById('attachment').click()" 
                                            class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-secondary transition-colors">
                                        <i class="fas fa-folder-open mr-2"></i>
                                        Pilih File
                                    </button>
                                </div>
                            </div>
                            <div id="fileName" class="mt-3 text-sm text-gray-600 hidden flex items-center justify-center space-x-2">
                                <i class="fas fa-file text-primary"></i>
                                <span id="fileNameText"></span>
                                <button type="button" onclick="removeFile()" class="text-rose-500 hover:text-rose-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @error('attachment')
                                <div class="flex items-center mt-2 text-sm text-rose-600">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200">
                            <!-- Tombol Kembali Mobile -->
                            <a href="{{ route('requests.index') }}" class="sm:hidden w-full flex items-center justify-center space-x-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali</span>
                            </a>
                            
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <!-- Tombol Kembali Desktop -->
                                <a href="{{ route('requests.index') }}" class="hidden sm:flex items-center space-x-2 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-arrow-left"></i>
                                    <span>Kembali</span>
                                </a>
                                <button type="submit" class="flex-1 sm:flex-none flex items-center justify-center space-x-2 px-6 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition-colors shadow-md hover:shadow-lg">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    <span>Kirim Pengajuan</span>
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
                            <h3 class="font-semibold text-blue-800 text-sm">Tips Pengajuan yang Baik</h3>
                            <ul class="mt-2 text-xs text-blue-700 space-y-1">
                                <li>• Pilih tipe pengajuan yang sesuai dengan kebutuhan</li>
                                <li>• Berikan judul yang jelas dan deskriptif</li>
                                <li>• Jelaskan secara detail masalah yang dihadapi</li>
                                <li>• Lampirkan foto atau dokumen pendukung jika ada</li>
                                <li>• Pastikan data yang dimasukkan sudah benar sebelum mengirim</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Character counter for description
        const descriptionTextarea = document.getElementById('description');
        const charCount = document.getElementById('charCount');

        descriptionTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length + ' karakter';
        });

        // File upload handling
        const fileInput = document.getElementById('attachment');
        const fileUploadArea = document.getElementById('fileUploadArea');
        const fileNameDiv = document.getElementById('fileName');
        const fileNameText = document.getElementById('fileNameText');

        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const file = this.files[0];
                fileNameText.textContent = file.name;
                fileNameDiv.classList.remove('hidden');
                fileUploadArea.classList.add('hidden');
            }
        });

        function removeFile() {
            fileInput.value = '';
            fileNameDiv.classList.add('hidden');
            fileUploadArea.classList.remove('hidden');
        }

        // Drag and drop functionality
        fileUploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                const file = e.dataTransfer.files[0];
                fileNameText.textContent = file.name;
                fileNameDiv.classList.remove('hidden');
                this.classList.add('hidden');
            }
        });

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const requiredInputs = form.querySelectorAll('[required]');
            
            requiredInputs.forEach(input => {
                input.addEventListener('invalid', function(e) {
                    e.preventDefault();
                    this.classList.add('border-rose-500');
                    
                    const errorDiv = this.parentElement.querySelector('.text-rose-600');
                    if (errorDiv) {
                        errorDiv.classList.remove('hidden');
                    }
                });
                
                input.addEventListener('input', function() {
                    this.classList.remove('border-rose-500');
                    const errorDiv = this.parentElement.querySelector('.text-rose-600');
                    if (errorDiv) {
                        errorDiv.classList.add('hidden');
                    }
                });
            });

            // Initialize character count
            charCount.textContent = descriptionTextarea.value.length + ' karakter';
        });

        // File upload area click
        fileUploadArea.addEventListener('click', function() {
            fileInput.click();
        });
    </script>
</body>
</html>
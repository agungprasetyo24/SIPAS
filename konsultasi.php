<?php
session_start();
include 'koneksi.php';
include 'auth_check.php';
check_login();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Konsultasi Pembelajaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom styling for select options */
        select {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        select option {
            background-color: #1a1a1a;
            color: white;
            padding: 12px;
        }

        select option:hover,
        select option:focus,
        select option:active {
            background-color: #2d2d2d;
        }

        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' height='24' viewBox='0 0 24 24' width='24'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen">
    <nav class="backdrop-blur-lg bg-white/10 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                <div class="text-white font-bold text-2xl">SIPAS</div>
                <div class="flex items-center space-x-4">
                    <span class="text-white/80">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <button onclick="document.getElementById('logoutModal').classList.remove('hidden')"
                        class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-lg 
                                   backdrop-blur-sm transition-all duration-300">
                        Keluar
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl p-8">
            <h2 class="text-3xl font-bold text-white mb-8 text-center">
                Rekomendasi Pembelajaran
            </h2>

            <form action="hasil.php" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label class="block text-sm font-medium text-white/80 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" required
                            class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                      text-white placeholder-white/50 focus:outline-none 
                                      focus:ring-2 focus:ring-white/50">
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-white/80 mb-2">Umur</label>
                        <input type="number" name="umur" required min="15" max="100"
                            class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                      text-white placeholder-white/50 focus:outline-none 
                                      focus:ring-2 focus:ring-white/50">
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-white/80 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" required
                            class="custom-select w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                       text-white placeholder-white/50 focus:outline-none 
                                       focus:ring-2 focus:ring-white/50 hover:bg-white/20 
                                       transition-all duration-300 cursor-pointer">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-white/80 mb-2">Bidang Minat</label>
                        <select name="bidang_minat" id="bidang_minat" required
                            class="custom-select w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                       text-white placeholder-white/50 focus:outline-none 
                                       focus:ring-2 focus:ring-white/50 hover:bg-white/20 
                                       transition-all duration-300 cursor-pointer">
                            <option value="">Pilih Bidang Minat</option>
                            <option value="Pemrograman">Pemrograman</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Desain">Desain</option>
                        </select>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-white/80 mb-2">Spesialisasi</label>
                        <select name="spesialisasi" id="spesialisasi" required
                            class="custom-select w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                       text-white placeholder-white/50 focus:outline-none 
                                       focus:ring-2 focus:ring-white/50 hover:bg-white/20 
                                       transition-all duration-300 cursor-pointer">
                            <option value="">Pilih Bidang Minat Terlebih Dahulu</option>
                        </select>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-white/80 mb-2">Tingkat Keahlian</label>
                        <select name="tingkat_keahlian" required
                            class="custom-select w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                       text-white placeholder-white/50 focus:outline-none 
                                       focus:ring-2 focus:ring-white/50 hover:bg-white/20 
                                       transition-all duration-300 cursor-pointer">
                            <option value="">Pilih Tingkat Keahlian</option>
                            <option value="Pemula">Pemula</option>
                            <option value="Menengah">Menengah</option>
                            <option value="Mahir">Mahir</option>
                        </select>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-white/80 mb-2">Metode Pembelajaran</label>
                        <select name="metode_pembelajaran" required
                            class="custom-select w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                       text-white placeholder-white/50 focus:outline-none 
                                       focus:ring-2 focus:ring-white/50 hover:bg-white/20 
                                       transition-all duration-300 cursor-pointer">
                            <option value="">Pilih Metode Pembelajaran</option>
                            <option value="Video">Video Tutorial</option>
                            <option value="Artikel">Artikel & Dokumentasi</option>
                            <option value="Buku">Buku</option>
                        </select>
                    </div>
                </div>
                <div class="mt-8 flex justify-between">
                    <a href="home.php" class="btn btn-secondary text-white/80">Kembali</a>
                    <button type="submit" class="btn btn-primary bg-blue-600 text-white px-6 py-2 rounded-lg">Dapatkan Rekomendasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Logout Modal -->
    <div id="logoutModal" class="hidden fixed inset-0 backdrop-blur-sm bg-black/50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Logout</h3>
            <p class="text-gray-500 mb-6">Apakah Anda yakin ingin keluar?</p>
            <div class="flex justify-end space-x-4">
                <button onclick="document.getElementById('logoutModal').classList.add('hidden')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">
                    Batal
                </button>
                <button onclick="handleLogout()"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg">
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>

    <script>
    function handleLogout() {
        fetch('ajax_logout.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'index.php';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                window.location.href = 'index.php'; // Fallback redirect
            });
    }
    </script>
    <script src="script.js"></script>
</body>

</html>
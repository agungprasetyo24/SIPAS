<?php
session_start();
include 'koneksi.php'; // Add this line
include 'auth_check.php';
check_login();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Learning Path Recommender</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 min-h-screen">
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

    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl p-8 text-white">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold mb-4 bg-clip-text text-transparent 
                           bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500">
                    Mulailah temukan minatmu!
                </h1>
                <p class="text-xl text-white/80 max-w-2xl mx-auto">
                    Temukan jalur pembelajaran yang sesuai dengan minat dan kemampuanmu!
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="group backdrop-blur-lg bg-white/10 rounded-2xl p-6 
                            transition-all duration-300 hover:transform hover:-translate-y-2 hover:bg-white/20">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-indigo-500/20">
                        <i class="fas fa-code text-2xl text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Pemrograman</h3>
                    <p class="text-white/70">Pelajari berbagai bahasa pemrograman, framework, dan teknologi pengembangan web & mobile</p>
                </div>

                <div class="group backdrop-blur-lg bg-white/10 rounded-2xl p-6 
                            transition-all duration-300 hover:transform hover:-translate-y-2 hover:bg-white/20">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-blue-500/20">
                        <i class="fas fa-network-wired text-2xl text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Jaringan</h3>
                    <p class="text-white/70">Eksplorasi dunia jaringan komputer, keamanan cyber, dan teknologi cloud computing</p>
                </div>

                <div class="group backdrop-blur-lg bg-white/10 rounded-2xl p-6 
                            transition-all duration-300 hover:transform hover:-translate-y-2 hover:bg-white/20">
                    <div class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-pink-500/20">
                        <i class="fas fa-palette text-2xl text-pink-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Desain</h3>
                    <p class="text-white/70">Kembangkan kreativitas dalam UI/UX design, graphic design, dan motion design</p>
                </div>
            </div>

            <div class="backdrop-blur-lg bg-white/10 rounded-2xl p-8 mt-12">
                <h2 class="text-2xl font-bold text-white mb-6">Riwayat Konsultasi Terbaru</h2>

                <?php
                $user_id = $_SESSION['user_id'];
                $query = "SELECT * FROM hasil_konsultasi ORDER BY tanggal DESC LIMIT 5";
                $result = mysqli_query($koneksi, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo '<div class="space-y-4">';
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <div class="bg-white/5 rounded-xl p-4 hover:bg-white/10 transition-all">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-white font-medium"><?php echo htmlspecialchars($row['nama']); ?></h3>
                                    <p class="text-white/70 text-sm"><?php echo htmlspecialchars($row['bidang_minat']); ?> - <?php echo htmlspecialchars($row['spesialisasi']); ?></p>
                                </div>
                                <span class="text-white/50 text-sm"><?php echo date('d M Y', strtotime($row['tanggal'])); ?></span>
                            </div>
                            <div class="mt-2">
                                <p class="text-white/90">Rekomendasi: <?php echo htmlspecialchars($row['rekomendasi']); ?></p>
                                <div class="flex justify-between items-center mt-2">
                                    <span class="text-white/70 text-sm">Probabilitas: <?php echo number_format($row['probabilitas'], 2); ?>%</span>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                    echo '</div>';

                    echo '<div class="text-center mt-6">
                        <a href="riwayat.php" class="inline-block px-6 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-all">
                            Lihat Semua Riwayat
                        </a>
                    </div>';
                } else {
                    echo '<p class="text-white/70 text-center">Belum ada riwayat konsultasi</p>';
                }
                ?>
            </div>

            <div class="text-center mt-8">
                <a href="konsultasi.php"
                    class="inline-flex items-center px-8 py-3 rounded-xl text-base font-medium
                          text-white bg-gradient-to-r from-indigo-600 to-purple-600 
                          hover:from-indigo-700 hover:to-purple-700 
                          transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-arrow-right mr-2"></i>
                    Mulai Konsultasi
                </a>
            </div>
        </div>
    </div>

    <div id="logoutModal" class="hidden fixed inset-0 backdrop-blur-sm bg-black/50 flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 transform transition-all">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Logout</h3>
            <p class="text-gray-500 mb-6">Apakah Anda yakin ingin keluar?</p>
            <div class="flex justify-end space-x-4">
                <button onclick="document.getElementById('logoutModal').classList.add('hidden')"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    Batal
                </button>
                <button onclick="handleLogout()"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
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
</body>

</html>
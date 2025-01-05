<?php
session_start();
include 'koneksi.php';
include 'auth_check.php';
check_login();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Riwayat Konsultasi</title>
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
        <div class="backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-white">Riwayat Konsultasi</h2>
                <a href="home.php" class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>

            <?php
            $per_page = 10;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $start = ($page - 1) * $per_page;

            $query = "SELECT * FROM hasil_konsultasi ORDER BY tanggal DESC LIMIT $start, $per_page";
            $result = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<div class="space-y-4">';
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="bg-white/5 rounded-xl p-6 hover:bg-white/10 transition-all">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-white text-xl font-medium"><?php echo htmlspecialchars($row['nama']); ?></h3>
                                <p class="text-white/70"><?php echo htmlspecialchars($row['bidang_minat']); ?> - <?php echo htmlspecialchars($row['spesialisasi']); ?></p>
                            </div>
                            <span class="text-white/50"><?php echo date('d M Y H:i', strtotime($row['tanggal'])); ?></span>
                        </div>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-white/70">Tingkat Keahlian: <?php echo htmlspecialchars($row['tingkat_keahlian']); ?></p>
                                <p class="text-white/70">Metode Pembelajaran: <?php echo htmlspecialchars($row['metode_pembelajaran']); ?></p>
                            </div>
                            <div>
                                <p class="text-white font-medium">Rekomendasi: <?php echo htmlspecialchars($row['rekomendasi']); ?></p>
                                <p class="text-white/70">Probabilitas: <?php echo number_format($row['probabilitas'], 2); ?>%</p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-white/10">
                            <p class="text-white/70">
                                <span class="text-white">Rujukan:</span> <?php echo htmlspecialchars($row['rujukan']); ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }
                echo '</div>';

                // Pagination
                $query = "SELECT COUNT(*) as total FROM hasil_konsultasi";
                $result = mysqli_query($koneksi, $query);
                $row = mysqli_fetch_assoc($result);
                $total_pages = ceil($row['total'] / $per_page);

                if ($total_pages > 1) {
                    echo '<div class="flex justify-center space-x-2 mt-8">';
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $active = $i === $page ? 'bg-white/20' : 'bg-white/5';
                        echo "<a href='?page=$i' class='px-4 py-2 $active text-white rounded-lg hover:bg-white/20 transition-all'>$i</a>";
                    }
                    echo '</div>';
                }
            } else {
                echo '<p class="text-white/70 text-center">Belum ada riwayat konsultasi</p>';
            }
            ?>
        </div>
    </div>

    <!-- Logout Modal -->
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
</body>

</html>

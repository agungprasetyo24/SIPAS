<?php
session_start();
include 'koneksi.php';
include 'auth_check.php';
check_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
     header('Location: konsultasi.php');
     exit();
}

function query_db($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        die('Database query failed: ' . mysqli_error($koneksi));
    }
    return $result;
}

$formData = $_POST;
error_log('Form data retrieved: ' . print_r($formData, true));

$bidang_minat = mysqli_real_escape_string($koneksi, $formData['bidang_minat']);
$tingkat_keahlian = mysqli_real_escape_string($koneksi, $formData['tingkat_keahlian']);
$metode_pembelajaran = mysqli_real_escape_string($koneksi, $formData['metode_pembelajaran']);
$spesialisasi = mysqli_real_escape_string($koneksi, $formData['spesialisasi']);

$query_total = "SELECT COUNT(*) as total FROM dataset 
                WHERE bidang_minat = '$bidang_minat' 
                AND spesialisasi = '$spesialisasi'";
$result_total = query_db($query_total);
$total_data = mysqli_fetch_assoc($result_total)['total'];

$query_rekomendasi = "SELECT rekomendasi, COUNT(*) as count 
                      FROM dataset 
                      WHERE bidang_minat = '$bidang_minat' 
                      AND spesialisasi = '$spesialisasi'
                      GROUP BY rekomendasi";
$result_rekomendasi = query_db($query_rekomendasi);
$probabilities = array();
$debug_info = [];

while ($row = mysqli_fetch_assoc($result_rekomendasi)) {
     $rekomendasi = $row['rekomendasi'];
     $count = $row['count'];

     $prior = $count / $total_data;

     $query_conditional = "SELECT COUNT(*) as count 
                         FROM dataset 
                         WHERE rekomendasi = '$rekomendasi' 
                         AND bidang_minat = '$bidang_minat'
                         AND spesialisasi = '$spesialisasi'
                         AND tingkat_keahlian = '$tingkat_keahlian' 
                         AND metode_pembelajaran = '$metode_pembelajaran'";

     $result_conditional = query_db($query_conditional);
     $conditional_count = mysqli_fetch_assoc($result_conditional)['count'];

     $conditional_prob = ($conditional_count + 1) / ($count + 2);

     $posterior = $prior * $conditional_prob;

     if ($posterior > 0) {
          $probabilities[$rekomendasi] = $posterior;
          $debug_info[$rekomendasi] = [
               'prior' => $prior,
               'conditional_prob' => $conditional_prob,
               'posterior' => $posterior
          ];
     }
}

if (empty($probabilities)) {
     $query_default = "SELECT rekomendasi 
                      FROM dataset 
                      WHERE bidang_minat = '$bidang_minat' 
                      AND spesialisasi = '$spesialisasi'
                      LIMIT 1";
     $result_default = query_db($query_default);
     $default_rec = mysqli_fetch_assoc($result_default);
     if ($default_rec) {
          $probabilities[$default_rec['rekomendasi']] = 1;
          $debug_info[$default_rec['rekomendasi']] = [
               'prior' => 1,
               'conditional_prob' => 1,
               'posterior' => 1
          ];
     }
}

arsort($probabilities);
$recommended = array_key_first($probabilities);
$probability = $probabilities[$recommended] * 100;

$query_rujukan = "SELECT rujukan FROM dataset WHERE rekomendasi = '$recommended' LIMIT 1";
$result_rujukan = query_db($query_rujukan);
$rujukan = mysqli_fetch_assoc($result_rujukan)['rujukan'];

$tanggal = date('Y-m-d H:i:s');
$nama = mysqli_real_escape_string($koneksi, $formData['nama']);
$umur = (int)$formData['umur'];
$jenis_kelamin = mysqli_real_escape_string($koneksi, $formData['jenis_kelamin']);

$query_simpan = "INSERT INTO hasil_konsultasi 
                (tanggal, nama, umur, jenis_kelamin, bidang_minat, spesialisasi,
                 tingkat_keahlian, metode_pembelajaran, rekomendasi, rujukan, probabilitas) 
                VALUES 
                ('$tanggal', '$nama', $umur, '$jenis_kelamin', '$bidang_minat', 
                 '$spesialisasi', '$tingkat_keahlian', '$metode_pembelajaran', 
                 '$recommended', '$rujukan', $probability)";
query_db($query_simpan);

?>

<!DOCTYPE html>
<html>

<head>
     <title>Hasil Rekomendasi</title>
     <script src="https://cdn.tailwindcss.com"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen py-12 px-4">
     <div class="max-w-4xl mx-auto">
          <div class="backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl p-8">
               <h2 class="text-3xl font-bold text-white mb-8 text-center">
                    Hasil Rekomendasi Belajar
               </h2>

               <div class="space-y-8">
                    <div>
                         <h3 class="text-xl text-white/90 mb-4">Data Konsultasi:</h3>
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                              <div class="bg-white/10 rounded-lg p-4">
                                   <span class="text-white/60">Nama:</span>
                                   <p class="text-white"><?php echo $formData['nama']; ?></p>
                              </div>
                              <div class="bg-white/10 rounded-lg p-4">
                                   <span class="text-white/60">Umur:</span>
                                   <p class="text-white"><?php echo $formData['umur']; ?></p>
                              </div>
                              <div class="bg-white/10 rounded-lg p-4">
                                   <span class="text-white/60">Jenis Kelamin:</span>
                                   <p class="text-white"><?php echo $formData['jenis_kelamin']; ?></p>
                              </div>
                              <div class="bg-white/10 rounded-lg p-4">
                                   <span class="text-white/60">Bidang Minat:</span>
                                   <p class="text-white"><?php echo $bidang_minat; ?></p>
                              </div>
                              <div class="bg-white/10 rounded-lg p-4">
                                   <span class="text-white/60">Spesialisasi:</span>
                                   <p class="text-white"><?php echo $spesialisasi; ?></p>
                              </div>
                              <div class="bg-white/10 rounded-lg p-4">
                                   <span class="text-white/60">Tingkat Keahlian:</span>
                                   <p class="text-white"><?php echo $tingkat_keahlian; ?></p>
                              </div>
                              <div class="bg-white/10 rounded-lg p-4">
                                   <span class="text-white/60">Metode Pembelajaran:</span>
                                   <p class="text-white"><?php echo $metode_pembelajaran; ?></p>
                              </div>
                         </div>
                    </div>

                    <div class="bg-white/20 backdrop-blur-lg rounded-xl p-6 space-y-4">
                         <h4 class="text-2xl font-semibold text-white">Rekomendasi:</h4>
                         <p class="text-xl text-white/90"><?php echo $recommended; ?></p>
                         <div class="h-px bg-white/20 my-4"></div>
                         <div class="flex items-center">
                              <div class="text-white/80">
                                   Tingkat Kepercayaan:
                                   <span class="text-white font-bold">
                                        <?php echo number_format($probability, 2); ?>%
                                   </span>
                              </div>
                         </div>
                         <div class="h-px bg-white/20 my-4"></div>
                         <h5 class="text-lg font-medium text-white">
                              Rujukan <?php echo $metode_pembelajaran; ?> yang Direkomendasikan:
                         </h5>
                         <p class="text-white/90"><?php echo $rujukan; ?></p>
                    </div>

                    <div class="mt-8">
                         <h5 class="text-xl text-white mb-4">Detail Perhitungan:</h5>
                         <div class="overflow-x-auto">
                              <table class="w-full text-white/90">
                                   <thead class="bg-white/10">
                                        <tr>
                                             <th class="px-4 py-2 text-left">Rekomendasi</th>
                                             <th class="px-4 py-2 text-left">Prior</th>
                                             <th class="px-4 py-2 text-left">Conditional</th>
                                             <th class="px-4 py-2 text-left">Posterior</th>
                                        </tr>
                                   </thead>
                                   <tbody class="divide-y divide-white/10">
                                        <?php
                                        uasort($debug_info, function ($a, $b) {
                                             return $b['posterior'] <=> $a['posterior'];
                                        });

                                        foreach ($debug_info as $rec => $info): ?>
                                             <tr class="hover:bg-white/5">
                                                  <td class="px-4 py-2"><?php echo $rec; ?></td>
                                                  <td class="px-4 py-2"><?php echo number_format($info['prior'], 4); ?></td>
                                                  <td class="px-4 py-2"><?php echo number_format($info['conditional_prob'], 4); ?></td>
                                                  <td class="px-4 py-2"><?php echo number_format($info['posterior'], 4); ?></td>
                                             </tr>
                                        <?php endforeach; ?>
                                   </tbody>
                              </table>
                         </div>
                    </div>

                    <div class="flex justify-center mt-8">
                         <a href="home.php"
                              class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg 
                              transition duration-300 ease-in-out transform hover:-translate-y-1">
                              Kembali ke Beranda
                         </a>
                    </div>
               </div>
          </div>
     </div>
</body>

</html>
<?php
unset($_SESSION['form_data']);
?>
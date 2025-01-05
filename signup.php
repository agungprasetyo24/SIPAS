<?php
session_start();
include 'koneksi.php';

if (isset($_POST['signup'])) {
     $username = mysqli_real_escape_string($koneksi, $_POST['username']);
     $email = mysqli_real_escape_string($koneksi, $_POST['email']);
     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

     $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
     $check_result = mysqli_query($koneksi, $check_query);

     if (mysqli_num_rows($check_result) > 0) {
          echo "<script>
             setTimeout(function() {
                 Swal.fire({
                     title: 'Gagal!',
                     text: 'Username atau email sudah digunakan',
                     icon: 'error',
                     confirmButtonText: 'OK',
                     confirmButtonColor: '#EF4444',
                     showClass: {
                         popup: 'animate__animated animate__fadeIn'
                     }
                 });
             }, 100);
         </script>";
     } else {
          $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
          if (mysqli_query($koneksi, $query)) {
               echo "<script>
                 setTimeout(function() {
                     Swal.fire({
                         title: 'Berhasil!',
                         text: 'Akun berhasil dibuat',
                         icon: 'success',
                         confirmButtonText: 'OK',
                         confirmButtonColor: '#4F46E5',
                         showClass: {
                             popup: 'animate__animated animate__fadeIn'
                         }
                     }).then((result) => {
                         if (result.isConfirmed) {
                             window.location.href = 'index.php';
                         }
                     });
                 }, 100);
             </script>";
          } else {
               echo "<script>
                 setTimeout(function() {
                     Swal.fire({
                         title: 'Gagal!',
                         text: 'Terjadi kesalahan saat membuat akun',
                         icon: 'error',
                         confirmButtonText: 'OK',
                         confirmButtonColor: '#EF4444',
                         showClass: {
                             popup: 'animate__animated animate__fadeIn'
                         }
                     });
                 }, 100);
             </script>";
          }
     }
}
?>

<!DOCTYPE html>
<html>

<head>
     <title>Daftar</title>
     <script src="https://cdn.tailwindcss.com"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 min-h-screen">
     <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
          <div class="max-w-md w-full backdrop-blur-xl bg-white/10 rounded-3xl shadow-2xl p-8">
               <div class="text-center mb-8">
                    <h2 class="text-4xl font-bold text-white mb-2">Buat Akun!</h2>
                    <p class="text-white/80">Buat akun dulu biar bisa masuk ...</p>
               </div>

               <?php if (isset($error)): ?>
                    <div class="mb-4 bg-red-500/10 backdrop-blur-sm text-white p-4 rounded-lg text-sm">
                         <?php echo $error; ?>
                    </div>
               <?php endif; ?>

               <form method="POST" class="space-y-6">
                    <div>
                         <label class="block text-sm font-medium text-white/80 mb-2">Username</label>
                         <input type="text" name="username" required
                              class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                   text-white placeholder-white/50 focus:outline-none 
                                   focus:ring-2 focus:ring-white/50">
                    </div>

                    <div>
                         <label class="block text-sm font-medium text-white/80 mb-2">Email</label>
                         <input type="email" name="email" required
                              class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                   text-white placeholder-white/50 focus:outline-none 
                                   focus:ring-2 focus:ring-white/50">
                    </div>

                    <div>
                         <label class="block text-sm font-medium text-white/80 mb-2">Password</label>
                         <div class="relative">
                              <input type="password" name="password" id="password" required
                                   class="w-full px-4 py-2 rounded-lg bg-white/10 border border-white/20 
                                        text-white placeholder-white/50 focus:outline-none 
                                        focus:ring-2 focus:ring-white/50">
                              <button type="button" onclick="togglePassword('password')"
                                   class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/50 hover:text-white/80">
                                   <i class="fas fa-eye-slash" id="password-toggle-icon"></i>
                              </button>
                         </div>
                    </div>

                    <button type="submit" name="signup"
                         class="w-full flex justify-center items-center py-3 px-4 rounded-xl text-base font-medium
                              text-white bg-gradient-to-r from-indigo-600 to-purple-600 
                              hover:from-indigo-700 hover:to-purple-700
                              transition-all duration-300 transform hover:-translate-y-1">
                         <i class="fas fa-user-plus mr-2"></i>
                         Buat Akun
                    </button>

                    <p class="text-center text-sm text-white/80">
                         Sudah punya akun?
                         <a href="index.php" class="font-medium text-indigo-400 hover:text-indigo-300">
                              Daftar!
                         </a>
                    </p>
               </form>
          </div>
     </div>

</body>
<script>
     function togglePassword(fieldId) {
          const passwordField = document.getElementById(fieldId);
          const toggleIcon = document.getElementById(fieldId + '-toggle-icon');

          if (passwordField.type === "password") {
               passwordField.type = "text";
               toggleIcon.classList.remove("fa-eye-slash");
               toggleIcon.classList.add("fa-eye");
          } else {
               passwordField.type = "password";
               toggleIcon.classList.remove("fa-eye");
               toggleIcon.classList.add("fa-eye-slash");
          }
     }
</script>

</html>
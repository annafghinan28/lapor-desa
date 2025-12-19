<?php
session_start();
$error_user = '';
$error_pass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include '../config/koneksi.php';

  $username = $_POST['username'];
  $password = $_POST['password'];
  $ingat    = isset($_POST['remember']);

  // Cek user
  $query = "SELECT * FROM admin WHERE username = '$username'";
  $result = mysqli_query($koneksi, $query);

  if (mysqli_num_rows($result) == 1) {
    $admin = mysqli_fetch_assoc($result);
    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin'] = $admin['username'];

      // Simpan cookie kalau centang ingat
      if ($ingat) {
        setcookie('ingat_admin', $username, time() + (30 * 24 * 60 * 60), '/');
      } else {
        setcookie('ingat_admin', '', time() - 3600, '/');
      }

      header('Location: admin.php');
      exit;
    } else {
      $error_pass = 'Password salah!';
    }
  } else {
    $error_user = 'Username tidak ditemukan!';
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin - Lapor Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-100 via-white to-blue-50">

  <div class="bg-white shadow-xl rounded-2xl flex w-full max-w-5xl overflow-hidden">
    
    <!-- KIRI -->
    <div class="w-1/2 bg-gradient-to-br from-blue-200 to-white p-10 flex flex-col justify-center items-center">
      <img src="https://cdn-icons-png.flaticon.com/512/4208/4208415.png" alt="Desa Digital" class="w-3/4 mb-8 drop-shadow-lg">
      <h2 class="text-xl font-semibold text-blue-800 text-center leading-relaxed">
        Permudah interaksi warga dengan <span class="text-blue-600 font-bold">Pemerintah Desa</span> secara online!
      </h2>
    </div>

    <!-- KANAN -->
    <div class="w-1/2 p-10 flex flex-col justify-center bg-white">
      <h2 class="text-3xl font-bold text-blue-700 mb-6">Selamat Datang Admin 👋</h2>

      <form method="POST" class="space-y-5">
        <!-- Username -->
        <div>
          <label class="block text-gray-700">Username</label>
          <input type="text" name="username"
                 value="<?= htmlspecialchars($_POST['username'] ?? ($_COOKIE['ingat_admin'] ?? '')) ?>"
                 class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                 required>
          <?php if ($error_user): ?>
            <p class="text-sm text-red-600 mt-1"><?= $error_user ?></p>
          <?php endif; ?>
        </div>

        <!-- Password -->
        <div>
          <label class="block text-gray-700">Password</label>
          <input type="password" name="password"
                 class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
                 required>
          <?php if ($error_pass): ?>
            <p class="text-sm text-red-600 mt-1"><?= $error_pass ?></p>
          <?php endif; ?>
        </div>

        <!-- Ingat saya & Lupa Password -->
        <div class="flex justify-between items-center">
          <label class="text-sm text-gray-600">
            <input type="checkbox" name="remember" <?= isset($_COOKIE['ingat_admin']) ? 'checked' : '' ?>>
            Ingat saya
          </label>
          <a href="reset_password.php" class="text-sm text-blue-500 hover:underline">Lupa password?</a>
        </div>

        <!-- Tombol Login -->
        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-300">
          Masuk
        </button>
      </form>

      <p class="text-xs text-center mt-6 text-gray-500">
        Dengan masuk, kamu menyetujui 
        <a href="#" onclick="bukaModal('modalKetentuan')" class="text-blue-500 hover:underline">Ketentuan</a> 
        dan 
        <a href="#" onclick="bukaModal('modalPrivasi')" class="text-blue-500 hover:underline">Privasi</a>.
      </p>
    </div>
  </div>

  <!-- Modal Ketentuan -->
  <div id="modalKetentuan" class="fixed inset-0 hidden z-50 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
      <h2 class="text-xl font-bold text-blue-600 mb-4">Ketentuan Penggunaan</h2>
      <p class="text-sm text-gray-700 mb-4">
        Dengan menggunakan sistem ini, Anda menyetujui bahwa data laporan yang dikirimkan bersifat benar dan dapat dipertanggungjawabkan. 
        Pihak desa berhak mengelola dan menindaklanjuti laporan sesuai kebijakan yang berlaku.
      </p>
      <button onclick="tutupModal('modalKetentuan')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">&times;</button>
    </div>
  </div>

  <!-- Modal Privasi -->
  <div id="modalPrivasi" class="fixed inset-0 hidden z-50 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
      <h2 class="text-xl font-bold text-blue-600 mb-4">Kebijakan Privasi</h2>
      <p class="text-sm text-gray-700 mb-4">
        Informasi pribadi Anda seperti nama dan laporan hanya digunakan untuk keperluan pemrosesan dan tindak lanjut laporan. 
        Kami menjaga kerahasiaan data Anda dan tidak akan menyebarkan kepada pihak ketiga tanpa izin.
      </p>
      <button onclick="tutupModal('modalPrivasi')" class="absolute top-2 right-2 text-gray-500 hover:text-red-500 text-xl">&times;</button>
    </div>
  </div>

  <!-- Script untuk Modal -->
  <script>
    function bukaModal(id) {
      document.getElementById(id).classList.remove('hidden');
    }
    function tutupModal(id) {
      document.getElementById(id).classList.add('hidden');
    }
  </script>

</body>
</html>
<?php
session_start();
include '../config/koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Ambil data admin dari database
$query = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);

// Cek apakah data ditemukan
if ($row = mysqli_fetch_assoc($result)) {
  // Verifikasi password
  if (password_verify($password, $row['password'])) {
    $_SESSION['admin'] = $row['username'];

    // 🔹 Penempatan bagian "Ingat Saya"
    if (isset($_POST['remember'])) {
      setcookie('ingat_admin', $username, time() + (86400 * 30), "/"); // simpan cookie 30 hari
    } else {
      setcookie('ingat_admin', '', time() - 3600, "/"); // hapus jika tidak dicentang
    }

    // Arahkan ke halaman admin
    header("Location: ../views/admin.php");
    exit();

  } else {
    echo "❌ Password salah.";
  }
} else {
  echo "❌ Akun tidak ditemukan.";
}
?>
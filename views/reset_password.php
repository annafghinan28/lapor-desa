<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $newpass  = password_hash($_POST['newpass'], PASSWORD_DEFAULT);

  $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
  if (mysqli_num_rows($cek) > 0) {
    $update = mysqli_query($koneksi, "UPDATE admin SET password='$newpass' WHERE username='$username'");
    if ($update) {
      echo "<script>alert('Password berhasil direset!'); window.location.href='login.php';</script>";
    } else {
      echo "❌ Gagal reset password.";
    }
  } else {
    echo "❌ Username tidak ditemukan.";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Reset Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex justify-center items-center bg-blue-50">
  <form method="POST" class="bg-white p-8 rounded shadow max-w-md w-full">
    <h2 class="text-xl font-semibold mb-4 text-blue-700">Reset Password Admin</h2>
    
    <label class="block mb-1">Username</label>
    <input type="text" name="username" required class="w-full border rounded px-3 py-2 mb-4">

    <label class="block mb-1">Password Baru</label>
    <input type="password" name="newpass" required class="w-full border rounded px-3 py-2 mb-6">

    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Reset</button>
    <p class="text-sm text-gray-500 text-center mt-4"><a href="login.php" class="text-blue-500 hover:underline">Kembali ke login</a></p>
  </form>
</body>
</html>
<?php
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
  $jenis = mysqli_real_escape_string($koneksi, $_POST['jenis']);
  $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
  $tanggal = date('Y-m-d');

  // Upload foto
  $foto = $_FILES['foto']['name'];
  $tmp = $_FILES['foto']['tmp_name'];
  $upload_dir = '../uploads/';

  if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
  }

  $nama_foto = time() . '_' . $foto;
  move_uploaded_file($tmp, $upload_dir . $nama_foto);

  // Simpan ke database
  $sql = "INSERT INTO laporan (nama, jenis, deskripsi, foto, tanggal_lapor, status)
          VALUES ('$nama', '$jenis', '$deskripsi', '$nama_foto', '$tanggal', 'Baru')";

  if (mysqli_query($koneksi, $sql)) {
    echo "<script>alert('Laporan berhasil dikirim!'); window.location.href = '../index.php';</script>";
  } else {
    echo "Gagal menyimpan laporan: " . mysqli_error($koneksi);
  }

} else {
  echo "Akses langsung tidak diizinkan.";
}
?>
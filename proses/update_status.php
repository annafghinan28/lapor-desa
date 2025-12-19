<?php
include '../config/koneksi.php';

$id     = $_POST['id'];
$status = $_POST['status'];
if (in_array($status, ['Menunggu', 'Diproses', 'Selesai'])) {
  $update = mysqli_query($koneksi, "UPDATE laporan SET status = '$status' WHERE id = $id");
}

$query = "UPDATE laporan SET status='$status' WHERE id=$id";
mysqli_query($koneksi, $query);

header("Location: ../views/admin.php");
?>
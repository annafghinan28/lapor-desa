<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;

include '../config/koneksi.php';

$kode = $_GET['kode'] ?? '';

$query = mysqli_query($koneksi, "SELECT * FROM laporan WHERE kode = '$kode'");
$data  = mysqli_fetch_assoc($query);

if (!$data) {
  die("Data tidak ditemukan.");
}

// Path foto (harus absolut atau base64 agar bisa ditampilkan di PDF)
$foto_path = '../uploads/' . $data['foto'];
$foto_base64 = '';
if (file_exists($foto_path)) {
    $foto_data = file_get_contents($foto_path);
    $foto_base64 = 'data:image/' . pathinfo($foto_path, PATHINFO_EXTENSION) . ';base64,' . base64_encode($foto_data);
}

// Siapkan HTML
$html = '
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Laporan - ' . $kode . '</title>
  <style>
    body { font-family: sans-serif; padding: 20px; font-size: 13px; }
    .header { text-align: center; margin-bottom: 20px; }
    .logo { width: 60px; }
    .judul { font-size: 16px; font-weight: bold; color: #1e3a8a; }
    .garis { border-top: 2px solid #000; margin: 10px 0; }
    .label { font-weight: bold; margin-top: 12px; }
    .box { border: 1px solid #ccc; padding: 8px; border-radius: 6px; margin-bottom: 10px; }
    .foto { margin-top: 20px; text-align: center; }
    .foto img { width: 250px; border-radius: 6px; border: 1px solid #999; }
    .ttd { margin-top: 50px; text-align: right; }
    .footer { text-align: center; margin-top: 40px; font-size: 11px; color: #777; }
  </style>
</head>
<body>

  <div class="header">
    <img src="https://upload.wikimedia.org/wikipedia/commons/9/9c/Logo_Kemendagri.png" class="logo" alt="logo">
    <div class="judul">PEMERINTAH DESA DIGITAL</div>
    <div class="sub">Jl. Contoh No. 123, Kecamatan AI, Kabupaten Data, Indonesia</div>
  </div>

  <div class="garis"></div>

  <h2 style="text-align:center; font-size:15px; color:#2563eb;">BUKTI PENGIRIMAN LAPORAN</h2>

  <p class="label">Kode Laporan:</p>
  <div class="box">' . $data['kode'] . '</div>

  <p class="label">Nama Pelapor:</p>
  <div class="box">' . htmlspecialchars($data['nama']) . '</div>

  <p class="label">Jenis Kerusakan:</p>
  <div class="box">' . htmlspecialchars($data['jenis']) . '</div>

  <p class="label">Deskripsi Kerusakan:</p>
  <div class="box">' . htmlspecialchars($data['deskripsi']) . '</div>

  <p class="label">Tanggal Lapor:</p>
  <div class="box">' . $data['tanggal_lapor'] . '</div>

  ' . ($foto_base64 ? '
  <div class="foto">
    <p class="label">Foto Bukti Laporan:</p>
    <img src="' . $foto_base64 . '" alt="Foto Laporan">
  </div>' : '') . '

  <div class="ttd">
    <p>Hormat kami,</p>
    <br><br><br>
    <strong>Petugas Desa</strong>
    <br><span style="font-size:10px; color:#999;">(Tanda tangan & stempel digital)</span>
  </div>

  <div class="footer">
    Dokumen ini dicetak secara otomatis dari sistem Lapor Desa | Dicetak tanggal: ' . date('d-m-Y H:i') . '
  </div>

</body>
</html>
';

// Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Bukti_Laporan_" . $kode . ".pdf", ["Attachment" => false]);
?>
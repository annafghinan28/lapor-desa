<?php
require_once '../vendor/autoload.php';
include '../config/koneksi.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Ambil data dari database
$sql = "SELECT * FROM laporan ORDER BY tanggal_lapor DESC";
$result = mysqli_query($koneksi, $sql);

// Siapkan HTML untuk PDF
$html = '
  <h2 style="text-align:center;">Laporan Pengaduan Warga Desa</h2>
  <table width="100%" border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jenis</th>
        <th>Deskripsi</th>
        <th>Tanggal</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>';

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
  $html .= '<tr>
              <td>' . $no++ . '</td>
              <td>' . htmlspecialchars($row['nama']) . '</td>
              <td>' . htmlspecialchars($row['jenis']) . '</td>
              <td>' . htmlspecialchars($row['deskripsi']) . '</td>
              <td>' . $row['tanggal_lapor'] . '</td>
              <td>' . $row['status'] . '</td>
            </tr>';
}

$html .= '</tbody></table>';

// Konfigurasi Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Unduh file
$dompdf->stream('laporan_desa_' . date('Ymd_His') . '.pdf', array("Attachment" => true));
exit;
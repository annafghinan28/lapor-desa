<?php
require_once '../vendor/autoload.php';
include '../config/koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Ambil data laporan
$sql = "SELECT * FROM laporan ORDER BY tanggal_lapor DESC";
$result = mysqli_query($koneksi, $sql);

// Siapkan spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Jenis');
$sheet->setCellValue('D1', 'Deskripsi');
$sheet->setCellValue('E1', 'Tanggal');
$sheet->setCellValue('F1', 'Status');

$no = 1;
$rowIndex = 2;

while ($row = mysqli_fetch_assoc($result)) {
  $sheet->setCellValue('A' . $rowIndex, $no++);
  $sheet->setCellValue('B' . $rowIndex, $row['nama']);
  $sheet->setCellValue('C' . $rowIndex, $row['jenis']);
  $sheet->setCellValue('D' . $rowIndex, $row['deskripsi']);
  $sheet->setCellValue('E' . $rowIndex, $row['tanggal_lapor']);
  $sheet->setCellValue('F' . $rowIndex, $row['status']);
  $rowIndex++;
}

// Nama file
$filename = 'laporan_desa_' . date('Ymd_His') . '.xlsx';

// Kirim header untuk download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

// Output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
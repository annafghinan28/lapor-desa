<?php
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cek Status Laporan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-tr from-blue-100 via-white to-blue-50 flex items-center justify-center p-6">

  <div class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl p-10 space-y-6">

    <!-- ✅ HEADLINE YANG DIBUAT LEBIH MENARIK -->
    <div class="relative bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 text-white rounded-xl p-6 shadow-lg mb-8 overflow-hidden">
      <div class="absolute -top-6 -left-6 w-28 h-28 bg-white bg-opacity-10 rounded-full animate-ping"></div>
      <div class="absolute -bottom-6 -right-6 w-28 h-28 bg-white bg-opacity-10 rounded-full animate-pulse"></div>

      <div class="relative z-10 text-center">
        <h1 class="text-4xl font-bold tracking-wide mb-2">🔎 Cek Status Laporan Anda</h1>
        <p class="text-sm text-blue-100">Lihat perkembangan laporan Anda dengan cepat dan mudah.</p>
      </div>
    </div>

    <!-- ✅ FORM CARI -->
    <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-700 font-semibold mb-1">Kode Pelaporan *</label>
        <input type="text" name="kode" required value="<?= $_GET['kode'] ?? '' ?>" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div>
        <label class="block text-sm text-gray-700 font-semibold mb-1">Tanggal Lapor (opsional)</label>
        <input type="date" name="tanggal" value="<?= $_GET['tanggal'] ?? '' ?>" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>
      <div class="md:col-span-2 text-center">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition">
          Cek Status
        </button>
      </div>
    </form>

    <!-- ✅ HASIL PENCARIAN -->
    <?php
    if (isset($_GET['kode'])) {
      $kode = mysqli_real_escape_string($koneksi, $_GET['kode']);
      $tanggal = $_GET['tanggal'] ?? '';

      $query = "SELECT * FROM laporan WHERE kode = '$kode'";
      if (!empty($tanggal)) {
        $query .= " AND tanggal_lapor = '$tanggal'";
      }

      $result = mysqli_query($koneksi, $query);

      if (!$result) {
        echo "<p class='text-red-600 font-semibold'>❌ Terjadi kesalahan: " . mysqli_error($koneksi) . "</p>";
      } elseif (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);

        // Badge warna status
        $statusColor = match($data['status']) {
          'Menunggu' => 'bg-yellow-100 text-yellow-800',
          'Diproses' => 'bg-orange-100 text-orange-800',
          'Selesai' => 'bg-green-100 text-green-800',
          default => 'bg-gray-100 text-gray-800',
        };

        // QR Code
        $url = urlencode("https://namadomainmu.com/proses/cetak_bukti.php?kode=" . $data['kode']);
        $qrCodeUrl = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=$url";

        echo "
        <div class='border-t pt-6'>
          <h2 class='text-xl font-semibold text-blue-700 mb-4'>📄 Detail Laporan Anda</h2>
          <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
            <div class='space-y-2'>
              <p><span class='font-medium text-gray-700'>Kode:</span> {$data['kode']}</p>
              <p><span class='font-medium text-gray-700'>Nama:</span> {$data['nama']}</p>
              <p><span class='font-medium text-gray-700'>Jenis:</span> {$data['jenis']}</p>
              <p><span class='font-medium text-gray-700'>Deskripsi:</span><br><span class='text-gray-600'>" . nl2br(htmlspecialchars($data['deskripsi'])) . "</span></p>
              <p><span class='font-medium text-gray-700'>Tanggal Lapor:</span> {$data['tanggal_lapor']}</p>
              <p><span class='font-medium text-gray-700'>Status:</span> <span class='px-3 py-1 rounded-full text-sm font-medium inline-block $statusColor'>{$data['status']}</span></p>
            </div>
            <div class='flex flex-col items-center space-y-4'>
              <img src='../uploads/{$data['foto']}' alt='Foto Laporan' class='rounded-lg w-52 border shadow'>
              <div class='text-center'>
                <p class='text-sm text-gray-600 mb-1'>📎 QR Code Bukti</p>
                <img src='$qrCodeUrl' alt='QR Code'>
              </div>
            </div>
          </div>
          <div class='text-center mt-6'>
            <a href='../proses/cetak_bukti.php?kode={$data['kode']}' target='_blank' class='inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition'>
              Cetak Bukti PDF
            </a>
          </div>
        </div>
        ";
      } else {
        echo "<p class='text-red-600 font-semibold text-center'>❌ Kode tidak ditemukan. Pastikan kode benar.</p>";
      }
    }
    ?>

    <!-- ✅ LINK KEMBALI -->
    <div class="text-center mt-10">
      <a href='index.php' class="text-blue-600 hover:underline text-sm">Kembali ke Form Laporan</a>
    </div>

  </div>

</body>
</html>
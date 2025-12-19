<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include '../config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Lapor Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-white to-blue-50 min-h-screen font-sans">

  <!-- HEADER -->
  <div class="flex items-center justify-between px-6 py-4 bg-white shadow-md">
    <h1 class="text-2xl font-bold text-black-700">Dashboard Admin - Lapor Desa</h1>
    <a href="../proses/proses_logout.php" class="text-sm bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
      Logout
    </a>
  </div>

  <!-- FILTER -->
  <div class="max-w-7xl mx-auto p-6">
    <form method="GET" class="flex flex-wrap gap-4 mb-6">
      <input type="text" name="cari_nama" placeholder="Cari nama..." class="border px-4 py-2 rounded w-48">
      <select name="filter_jenis" class="border px-4 py-2 rounded w-48">
        <option value="">Semua Jenis</option>
        <optgroup label="🚧 Jalan">
          <option value="Jalan Rusak">Jalan Rusak</option>
          <option value="Jalan Berlubang">Jalan Berlubang</option>
          <option value="Jalan Terhalang">Jalan Terhalang</option>
        </optgroup>
        <optgroup label="💡 Penerangan">
          <option value="Lampu Jalan Mati">Lampu Jalan Mati</option>
          <option value="Lampu Jalan Rusak">Lampu Jalan Rusak</option>
        </optgroup>
        <optgroup label="🚿 Air">
          <option value="Pipa Bocor">Pipa Bocor</option>
          <option value="Air Tidak Mengalir">Air Tidak Mengalir</option>
          <option value="Kualitas Air Buruk">Kualitas Air Buruk</option>
        </optgroup>
        <optgroup label="⚡ Listrik">
          <option value="Listrik Padam">Listrik Padam</option>
          <option value="Kabel Listrik Putus">Kabel Listrik Putus</option>
        </optgroup>
        <optgroup label="🏛️ Fasilitas Publik">
          <option value="Toilet Umum Rusak">Toilet Umum Rusak</option>
          <option value="Tempat Sampah Tidak Ada / Tidak Terawat">Tempat Sampah Tidak Ada / Tidak Terawat</option>
        </optgroup>
        <optgroup label="🌊 Drainase">
          <option value="Saluran Tersumbat">Saluran Tersumbat</option>
          <option value="Saluran Rusak">Saluran Rusak</option>
        </optgroup>
        <optgroup label="❓ Lain-lain">
          <option value="Lain-lain">Lain-lain</option>
        </optgroup>
      </select>

      <select name="filter_status" class="border px-4 py-2 rounded w-48">
        <option value="">Semua Status</option>
        <option value="Menunggu">Menunggu</option>
        <option value="Diproses">Diproses</option>
        <option value="Selesai">Selesai</option>
      </select>
      <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
        Filter
      </button>
    </form>

    <!-- Tombol Export -->
    <div class="flex gap-4 mb-6">
      <form action="../proses/export_excel.php" method="POST">
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
          Download Excel
        </button>
      </form>
      <form action="../proses/export_pdf.php" method="POST" target="_blank">
        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700">
          Download PDF
        </button>
      </form>
    </div>

    <!-- TABEL -->
    <div class="overflow-auto shadow rounded-lg">
      <table class="min-w-full bg-white border border-gray-200 text-sm text-left">
        <thead class="bg-blue-100 text-blue-800">
          <tr>
            <th class="py-3 px-4">No</th>
            <th class="py-3 px-4">Nama</th>
            <th class="py-3 px-4">Jenis</th>
            <th class="py-3 px-4">Deskripsi</th>
            <th class="py-3 px-4">Foto</th>
            <th class="py-3 px-4">Tanggal</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">

          <?php
          $where = [];
          if (!empty($_GET['cari_nama'])) {
            $nama = mysqli_real_escape_string($koneksi, $_GET['cari_nama']);
            $where[] = "nama LIKE '%$nama%'";
          }
          if (!empty($_GET['filter_jenis'])) {
            $jenis = mysqli_real_escape_string($koneksi, $_GET['filter_jenis']);
            $where[] = "jenis = '$jenis'";
          }
          if (!empty($_GET['filter_status'])) {
            $status = mysqli_real_escape_string($koneksi, $_GET['filter_status']);
            $where[] = "status = '$status'";
          }

          $filter_sql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";
          $sql = "SELECT * FROM laporan $filter_sql ORDER BY tanggal_lapor DESC";
          $result = mysqli_query($koneksi, $sql);
          $no = 1;

          while ($row = mysqli_fetch_assoc($result)) {
            // Warna status
            $statusClass = '';
            switch ($row['status']) {
              case 'Menunggu':
                $statusClass = 'bg-yellow-200 text-yellow-900 font-semibold border border-yellow-300';
                break;
              case 'Diproses':
                $statusClass = 'bg-blue-100 text-blue-800';
                break;
              case 'Selesai':
                $statusClass = 'bg-green-100 text-green-800';
                break;
              default:
                $statusClass = 'bg-gray-100 text-gray-800';
            }

            echo "<tr class='hover:bg-gray-50'>";
            echo "<td class='py-2 px-4'>" . $no++ . "</td>";
            echo "<td class='py-2 px-4'>" . htmlspecialchars($row['nama']) . "</td>";
            echo "<td class='py-2 px-4'>" . htmlspecialchars($row['jenis']) . "</td>";
            echo "<td class='py-2 px-4'>" . htmlspecialchars($row['deskripsi']) . "</td>";
            echo "<td class='py-2 px-4'><img src='../uploads/" . htmlspecialchars($row['foto']) . "' class='w-20'></td>";
            echo "<td class='py-2 px-4'>" . $row['tanggal_lapor'] . "</td>";
            echo "<td class='py-2 px-4'>
                    <span class='px-3 py-1 rounded-full text-xs font-semibold inline-block $statusClass'>
                      " . htmlspecialchars($row['status']) . "
                    </span>
                  </td>";
            echo "<td class='py-2 px-4'>
                    <form method='POST' action='../proses/update_status.php' class='flex gap-2'>
                      <input type='hidden' name='id' value='" . $row['id'] . "'>
                      <select name='status' class='border rounded px-2 py-1'>
                        <option disabled>Pilih Status</option>
                        <option " . ($row['status'] == 'Menunggu' ? 'selected' : '') . ">Menunggu</option>
                        <option " . ($row['status'] == 'Diproses' ? 'selected' : '') . ">Diproses</option>
                        <option " . ($row['status'] == 'Selesai' ? 'selected' : '') . ">Selesai</option>
                      </select>
                      <button type='submit' class='bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600'>Update</button>
                    </form>
                  </td>";
            echo "</tr>";
          }
          ?>

        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
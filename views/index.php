<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Beranda Warga - Lapor Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gradient-to-br from-blue-200 via-white to-blue-100 min-h-screen flex items-center justify-center font-sans">

  <div class="bg-white shadow-2xl rounded-3xl flex w-full max-w-5xl overflow-hidden">

    <!-- KIRI: Ilustrasi dan tagline -->
    <div class="w-1/2 bg-gradient-to-br from-blue-300 to-white p-10 flex flex-col justify-center items-center relative">
      <img src="https://cdn-icons-png.flaticon.com/512/6195/6195700.png" alt="Form Laporan Warga" class="w-3/4 mb-6 drop-shadow-lg">
      <h2 class="text-2xl font-semibold text-blue-800 text-center leading-relaxed">
        Laporkan masalah lingkungan desa Anda secara <span class="text-blue-600 font-bold">mudah & cepat</span>!
      </h2>

      <!-- Tombol Login Admin -->
      <a href="login.php" class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        🔐 Login Admin
      </a>
    </div>

    <!-- KANAN: Form -->
    <div class="w-1/2 p-10">

      <!-- Headline dengan latar belakang abstrak -->
      <div class="relative mb-6">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-100 via-white to-blue-200 rounded-xl opacity-60 blur-sm"></div>
        <h1 class="relative text-3xl font-extrabold text-blue-800 text-center py-4 z-10">
          📝 Form Laporan Warga
        </h1>
      </div>

      <form action="../proses/proses_laporan.php" method="POST" enctype="multipart/form-data" class="space-y-5">

        <!-- Nama Pelapor -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Pelapor</label>
          <input type="text" name="nama" required
            class="w-full mt-1 p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">
        </div>

        <!-- Jenis Kerusakan -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Jenis Kerusakan</label>
          <select name="jenis" required
            class="w-full mt-1 p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200">

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
        </div>

        <!-- Deskripsi -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
          <textarea name="deskripsi" rows="3" required
            class="w-full mt-1 p-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-200"></textarea>
        </div>

        <!-- Upload Foto -->
        <div>
          <label class="block text-sm font-medium text-gray-700">Upload Foto</label>
          <input type="file" name="foto" accept="image/*" required
            class="w-full mt-1 p-3 border border-gray-300 rounded-xl">
        </div>

        <!-- Ketentuan dan Privasi -->
        <div class="flex items-start text-sm text-gray-600">
          <input type="checkbox" id="setuju" name="setuju" required class="mt-1 mr-2">
          <label for="setuju" class="select-none">
            Saya menyetujui 
            <button type="button" onclick="openModal()" class="text-blue-500 hover:underline">Ketentuan</button> dan 
            <button type="button" onclick="openModal()" class="text-blue-500 hover:underline">Privasi</button> yang berlaku.
          </label>
        </div>

        <!-- Tombol Kirim -->
        <div class="text-center">
          <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-xl transition duration-300 transform hover:scale-105">
            🚀 Kirim Laporan
          </button>
        </div>

        <!-- Link Cek Status -->
        <div class="text-center mt-3">
          <a href="cek_status.php" class="text-sm text-blue-600 hover:underline">🔍 Cek Status Laporan Anda</a>
        </div>
      </form>
    </div>
  </div>

  <!-- MODAL KETENTUAN DAN PRIVASI -->
  <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 max-w-xl relative">
      <h2 class="text-xl font-bold text-blue-700 mb-4">Ketentuan & Privasi</h2>
      <p class="text-sm text-gray-700">
        Data pribadi yang Anda masukkan hanya digunakan untuk keperluan identifikasi laporan dan tidak akan disebarluaskan. 
        Laporan palsu atau tidak relevan dapat dikenakan sanksi sesuai peraturan desa. Harap pastikan informasi yang Anda kirim adalah benar.
      </p>
      <button onclick="closeModal()" class="absolute top-2 right-3 text-red-600 text-xl">&times;</button>
    </div>
  </div>

  <script>
    function openModal() {
      document.getElementById("modal").classList.remove("hidden");
      document.getElementById("modal").classList.add("flex");
    }

    function closeModal() {
      document.getElementById("modal").classList.add("hidden");
    }
  </script>

</body>
</html>
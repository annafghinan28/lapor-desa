<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Form Laporan Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-gradient-to-r from-blue-200 to-blue-400 min-h-screen flex items-center justify-center font-sans">

  <div class="w-full max-w-xl bg-white p-10 rounded-2xl shadow-lg">
    <h1 class="text-4xl font-bold text-gray-800 text-center mb-8">
      📝 Form Laporan Warga Desa
    </h1>

    <form action="../proses/proses_laporan.php" method="POST" enctype="multipart/form-data" class="space-y-6">

      <div>
        <label class="block text-sm font-medium text-gray-700">Nama Pelapor</label>
        <input type="text" name="nama" required
               class="w-full mt-1 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Jenis Kerusakan</label>
        <select name="jenis" required
                class="w-full mt-1 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
          <optgroup label="Jalan">
            <option value="Jalan Rusak">Rusak</option>
            <option value="Jalan Berlubang">Berlubang</option>
            <option value="Jalan Terhalang">Terhalang</option>
          </optgroup>
          <optgroup label="Penerangan">
            <option value="Lampu Jalan Mati">Lampu Jalan Mati</option>
            <option value="Lampu Jalan Rusak">Lampu Jalan Rusak</option>
          </optgroup>
          <optgroup label="Air">
            <option value="Pipa Bocor">Pipa Bocor</option>
            <option value="Air Tidak Mengalir">Air Tidak Mengalir</option>
            <option value="Kualitas Air Buruk">Kualitas Air Buruk</option>
          </optgroup>
          <optgroup label="Listrik">
            <option value="Listrik Padam">Listrik Padam</option>
            <option value="Kabel Listrik Putus">Kabel Listrik Putus</option>
          </optgroup>
          <optgroup label="Fasilitas Publik">
            <option value="Toilet Umum Rusak">Toilet Umum Rusak</option>
            <option value="Tempat Sampah Tidak Terawat">Tempat Sampah Tidak Terawat</option>
          </optgroup>
          <optgroup label="Drainase">
            <option value="Saluran Tersumbat">Saluran Tersumbat</option>
            <option value="Saluran Rusak">Saluran Rusak</option>
          </optgroup>
          <option value="Lainnya">Lainnya</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
        <textarea name="deskripsi" rows="4" required
                  class="w-full mt-1 p-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Upload Foto</label>
        <input type="file" name="foto" accept="image/*" required
               class="w-full mt-1 p-4 border border-gray-300 rounded-lg">
      </div>

      <div class="text-xs text-center text-gray-500">
        Dengan mengirimkan laporan ini, Anda menyetujui
        <a href="#" onclick="bukaModal('modalKetentuan')" class="text-blue-600 hover:underline">Ketentuan</a> dan
        <a href="#" onclick="bukaModal('modalPrivasi')" class="text-blue-600 hover:underline">Privasi</a>.
      </div>

      <div class="text-center">
        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-4 rounded-lg transition duration-200 transform hover:scale-105">
          Kirim Laporan
        </button>
      </div>

      <div class="text-center mt-4">
        <a href="cek_status.php" class="text-blue-600 hover:underline font-medium text-sm">🔍 Cek Status Laporan Anda</a>
      </div>

    </form>
  </div>

  <!-- MODAL Ketentuan -->
  <div id="modalKetentuan" class="fixed inset-0 hidden z-50 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative">
      <h2 class="text-xl font-bold text-blue-600 mb-4">Ketentuan Penggunaan</h2>
      <p class="text-sm text-gray-700">
        Dengan mengisi dan mengirimkan laporan ini, Anda menyatakan bahwa informasi yang diberikan adalah benar dan dapat dipertanggungjawabkan.
        Pemerintah desa berhak menindaklanjuti laporan berdasarkan kebijakan yang berlaku.
      </p>
      <button onclick="tutupModal('modalKetentuan')" class="absolute top-2 right-4 text-gray-500 hover:text-red-500 text-xl">&times;</button>
    </div>
  </div>

  <!-- MODAL Privasi -->
  <div id="modalPrivasi" class="fixed inset-0 hidden z-50 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full relative">
      <h2 class="text-xl font-bold text-blue-600 mb-4">Kebijakan Privasi</h2>
      <p class="text-sm text-gray-700">
        Informasi pribadi Anda seperti nama dan data laporan hanya akan digunakan untuk keperluan penanganan masalah oleh pihak berwenang.
        Kami berkomitmen menjaga kerahasiaan data Anda dan tidak akan membagikannya tanpa persetujuan.
      </p>
      <button onclick="tutupModal('modalPrivasi')" class="absolute top-2 right-4 text-gray-500 hover:text-red-500 text-xl">&times;</button>
    </div>
  </div>

  <!-- Script Modal -->
  <script>
    function bukaModal(id) {
      document.getElementById(id).classList.remove('hidden');
    }
    function tutupModal(id) {
      document.getElementById(id).classList.add('hidden');
    }
  </script>

</body>
</html>
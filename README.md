# 🌐 Website Lapor Desa

Sistem pengaduan online untuk warga desa berbasis PHP dan MySQL dengan dashboard admin lengkap.

## 📋 Fitur Utama

### 👤 Untuk Warga
- 📝 Form laporan dengan 7 kategori (jalan, penerangan, air, dll)
- 📸 Upload foto bukti kerusakan
- 🔍 Cek status laporan dengan kode unik
- 🖨️ Cetak bukti laporan dalam format PDF
- 📱 Responsive design (bisa diakses via HP)

### 👨‍💼 Untuk Admin Desa
- 🔐 Login system dengan keamanan password hash
- 📊 Dashboard dengan semua laporan
- 🔎 Filter & pencarian canggih
- ✏️ Update status laporan (Menunggu/Diproses/Selesai)
- 📥 Export data ke Excel & PDF
- 👁️ Preview foto bukti langsung di dashboard

## 🛠️ Teknologi

- **Backend**: PHP Native
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript, Tailwind CSS
- **Library**: Dompdf (PDF), PhpSpreadsheet (Excel)

## 📁 Struktur Folder
```
lapor_desa/
├── config/           # Koneksi database
├── proses/          # Semua file proses PHP
├── views/           # Halaman frontend
├── uploads/         # Folder upload foto
└── vendor/          # Library pihak ketiga
```

## 🚀 Instalasi

1. **Clone/Download** project
2. **Import database** dari file `database.sql`
3. **Konfigurasi** file `config/koneksi.php`
4. **Install dependencies**:
   ```bash
   composer install
   ```
5. **Jalankan** di browser: `http://localhost/lapor_desa/views/`

## 🔧 Konfigurasi Database

Edit file `config/koneksi.php`:
```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lapor_desa";
```

## 👥 Login Default
- **Username**: admin
- **Password**: 123 (direkomendasikan diubah setelah login)

## 📸 Preview
- **Halaman Warga**: Form laporan sederhana
- **Halaman Admin**: Dashboard dengan tabel dan filter
- **Cek Status**: Tracking dengan QR Code

## 📄 Lisensi
Proyek ini dikembangkan untuk kepentingan pendidikan dan komunitas.

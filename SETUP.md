# Panduan Setup Cepat - Absensi Siswa

## Langkah-Langkah Setup (Laragon + DBeaver)

### 1. Pastikan Laragon Sudah Berjalan
- Buka Laragon
- Klik "Start All"
- Pastikan Apache/Nginx dan MySQL berjalan (hijau)

### 2. Buat Database di DBeaver
1. Buka DBeaver
2. Koneksi ke MySQL (localhost:3306, user: root, password: kosong)
3. Klik kanan pada database → Create → Database
4. Nama: `absensi_siswa`
5. Charset: `utf8mb4`
6. Collation: `utf8mb4_unicode_ci`
7. Klik OK

### 3. Konfigurasi .env
1. Buka folder project di VS Code
2. Copy `.env.example` menjadi `.env`
3. Edit `.env`:
   ```env
   APP_NAME="Absensi Siswa"
   APP_URL=http://absensi-siswa.test
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=absensi_siswa
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 4. Install & Setup Laravel
Buka terminal di VS Code (Ctrl + `) atau terminal Laragon, lalu jalankan:

```bash
# Install dependencies
composer install

# Generate app key
php artisan key:generate

# Jalankan migration & seeder
php artisan migrate
php artisan db:seed
```

### 5. Akses Aplikasi
- **Via Laragon**: `http://absensi-siswa.test` atau `http://localhost/absensi-siswa/public`
- **Via Artisan**: `php artisan serve` → `http://localhost:8000`

### 6. Login Pertama Kali

**Admin:**
- Email: `admin@absensi.test`
- Password: `password`

**Siswa:**
- Register dengan NIS: `20240001` (atau NIS lain dari seeder)
- Email: bebas (contoh: `siswa1@email.com`)
- Password: minimal 8 karakter

## Fitur yang Tersedia

✅ Login untuk Admin & Siswa  
✅ Register hanya untuk Siswa (Admin tidak bisa register)  
✅ Dashboard berbeda untuk Admin & Siswa  
✅ Profil data (edit nama, email, password)  
✅ QR Code absensi (Admin generate, Siswa scan)  
✅ Manajemen Kelas & Siswa (Admin only)  
✅ Input absensi manual (Admin)  
✅ Rekap & Laporan PDF  

## Troubleshooting

**Error database connection:**
- Pastikan MySQL di Laragon running
- Cek nama database di `.env` sesuai dengan yang dibuat di DBeaver

**Halaman blank:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**QR Code tidak muncul:**
- Pastikan koneksi internet aktif (menggunakan CDN)

## Catatan Penting

- Admin **TIDAK BISA** register dari halaman register
- Siswa **HARUS** register dengan NIS yang sudah terdaftar di database
- QR Code berlaku 5 menit setelah di-generate
- Siswa harus login terlebih dahulu sebelum scan QR

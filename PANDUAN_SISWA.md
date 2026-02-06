# Panduan Lengkap untuk Siswa - Aplikasi Absensi Siswa

## 📋 Daftar Isi
1. [Cara Register Akun](#cara-register-akun)
2. [Cara Login](#cara-login)
3. [Dashboard Siswa](#dashboard-siswa)
4. [Cara Absensi via QR Code](#cara-absensi-via-qr-code)
5. [Edit Profil](#edit-profil)
6. [Troubleshooting](#troubleshooting)

---

## 1. Cara Register Akun

### Syarat Register:
- ✅ NIS harus sudah terdaftar di database oleh admin
- ✅ Email belum pernah digunakan
- ✅ Password minimal 8 karakter

### Langkah-Langkah:

1. **Buka halaman register**
   - Akses: `http://absensi-siswa.test/register`
   - Atau klik "Daftar di sini" di halaman login

2. **Isi form register:**
   - **NIS**: Masukkan Nomor Induk Siswa yang sudah terdaftar
     - Contoh: `20240001`, `20240002`, dll
     - NIS harus sudah ditambahkan admin di menu "Data Siswa"
   - **Email**: Masukkan email yang valid
     - Contoh: `siswa1@email.com`, `nama.siswa@gmail.com`
     - Email harus unik (belum pernah digunakan)
   - **Password**: Minimal 8 karakter
     - Contoh: `password123`, `siswa2024`, dll
   - **Konfirmasi Password**: Ketik ulang password yang sama

3. **Klik "Daftar Sekarang"**
   - Jika berhasil, Anda akan otomatis login
   - Redirect ke dashboard siswa

### Catatan Penting:
- ⚠️ **Admin tidak bisa register** - Hanya siswa yang bisa register
- ⚠️ Jika NIS tidak ditemukan, hubungi admin untuk menambahkan data siswa terlebih dahulu
- ⚠️ Jika NIS sudah memiliki akun, tidak bisa register lagi

---

## 2. Cara Login

### Langkah-Langkah:

1. **Buka halaman login**
   - Akses: `http://absensi-siswa.test/login`
   - Atau langsung dari halaman utama

2. **Masukkan kredensial:**
   - **Email**: Email yang digunakan saat register
   - **Password**: Password yang dibuat saat register
   - **Ingat saya** (opsional): Centang jika ingin tetap login

3. **Klik "Masuk"**
   - Jika berhasil, redirect ke dashboard siswa
   - Jika gagal, cek email dan password

### Lupa Password?
- Saat ini belum ada fitur reset password
- Hubungi admin untuk reset password
- Atau admin bisa reset via database

---

## 3. Dashboard Siswa

Setelah login, Anda akan melihat dashboard dengan informasi:

### Informasi Personal:
- **NIS**: Nomor Induk Siswa Anda
- **Kelas**: Kelas Anda saat ini
- **Status Absen Hari Ini**: Hadir/Izin/Sakit/Alpha

### Rekap Bulan Ini:
- **Hadir**: Jumlah hari hadir bulan ini
- **Izin**: Jumlah hari izin bulan ini
- **Sakit**: Jumlah hari sakit bulan ini
- **Alpha**: Jumlah hari alpha bulan ini

### Riwayat Absensi Terbaru:
- Tabel menampilkan 15 absensi terbaru
- Menampilkan: Tanggal, Status, Waktu Masuk

### Informasi QR Code:
- Panduan cara scan QR code untuk absen
- Pastikan sudah login sebelum scan

---

## 4. Cara Absensi via QR Code

### Langkah-Langkah:

1. **Pastikan sudah login**
   - Login ke aplikasi menggunakan HP atau laptop
   - Buka dashboard siswa

2. **Admin/Guru menampilkan QR Code**
   - Admin/guru akan membuka menu "Tampilkan QR Absen"
   - QR code akan muncul di layar proyektor/laptop

3. **Scan QR Code menggunakan HP:**
   - **Opsi A: Scan langsung dari HP**
     - Buka kamera HP
     - Arahkan ke QR code di layar
     - Klik notifikasi yang muncul
     - Otomatis redirect ke aplikasi dan absen tercatat
   
   - **Opsi B: Scan via browser**
     - Buka browser di HP
     - Login ke aplikasi
     - Scan QR code menggunakan kamera HP
     - Atau copy URL dari QR code dan buka di browser

4. **Konfirmasi absensi**
   - Setelah scan, akan muncul pesan sukses
   - Status absen hari ini akan berubah menjadi "Hadir"
   - Waktu masuk tercatat otomatis

### Catatan Penting:
- ⚠️ **QR Code berlaku 5 menit** - Scan segera setelah QR code ditampilkan
- ⚠️ **Hanya bisa absen sekali per hari** - Jika sudah absen, tidak bisa absen lagi
- ⚠️ **Harus sudah login** - Pastikan sudah login sebelum scan
- ⚠️ **Hanya siswa yang bisa absen** - Admin tidak bisa absen via QR

### Troubleshooting QR Code:
- **QR Code tidak bisa di-scan**: Pastikan QR code masih berlaku (belum 5 menit)
- **Sudah absen hari ini**: Tidak bisa absen 2x dalam sehari
- **Tidak redirect**: Pastikan sudah login dan koneksi internet aktif

---

## 5. Edit Profil

### Langkah-Langkah:

1. **Buka halaman profil**
   - Klik menu "Profil" di sidebar
   - Atau klik avatar di kanan atas → Profil

2. **Edit data profil:**
   - **Nama**: Bisa diubah
   - **Email**: Bisa diubah (harus unik)
   - **NIS**: Tidak bisa diubah (dari database)
   - **No. Telepon**: Bisa diubah
   - **Alamat**: Bisa diubah

3. **Ubah password (opsional):**
   - Isi "Password Baru" jika ingin mengubah password
   - Isi "Konfirmasi Password"
   - Kosongkan jika tidak ingin mengubah password

4. **Klik "Simpan Perubahan"**
   - Data akan tersimpan
   - Muncul notifikasi sukses

### Catatan:
- NIS dan Kelas tidak bisa diubah (harus melalui admin)
- Password minimal 8 karakter
- Email harus unik (tidak boleh sama dengan user lain)

---

## 6. Troubleshooting

### Masalah: NIS tidak ditemukan saat register
**Solusi:**
- Pastikan NIS sudah ditambahkan admin di menu "Data Siswa"
- Hubungi admin untuk menambahkan data siswa Anda
- Pastikan NIS yang dimasukkan benar (tanpa spasi)

### Masalah: Email sudah terdaftar
**Solusi:**
- Gunakan email lain yang belum pernah digunakan
- Atau hubungi admin jika email Anda sudah digunakan

### Masalah: Tidak bisa login
**Solusi:**
- Pastikan email dan password benar
- Cek apakah caps lock aktif
- Pastikan sudah register terlebih dahulu
- Hubungi admin jika masih tidak bisa

### Masalah: QR Code tidak bisa di-scan
**Solusi:**
- Pastikan QR code masih berlaku (belum 5 menit)
- Pastikan sudah login sebelum scan
- Pastikan koneksi internet aktif
- Coba refresh halaman

### Masalah: Sudah absen tapi tidak tercatat
**Solusi:**
- Refresh dashboard untuk melihat update terbaru
- Cek di menu "Riwayat Absensi Terbaru"
- Hubungi admin jika masih tidak muncul

### Masalah: Data siswa tidak ditemukan di dashboard
**Solusi:**
- Pastikan NIS sudah terdaftar dengan benar
- Hubungi admin untuk memastikan data siswa lengkap
- Pastikan siswa memiliki kelas yang aktif

---

## 📞 Bantuan

Jika mengalami masalah yang tidak bisa diselesaikan:
1. Hubungi admin sekolah
2. Sertakan screenshot error jika ada
3. Jelaskan langkah-langkah yang sudah dilakukan

---

## ✅ Checklist Sebelum Menggunakan Aplikasi

- [ ] NIS sudah terdaftar di database (cek dengan admin)
- [ ] Sudah register dengan email dan password
- [ ] Sudah login ke aplikasi
- [ ] Memahami cara scan QR code
- [ ] Memahami bahwa hanya bisa absen sekali per hari

---

**Selamat menggunakan aplikasi absensi siswa!** 🎓

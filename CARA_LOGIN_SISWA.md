# Cara Login untuk Siswa - Panduan Singkat

## ✅ Langkah-Langkah Login Siswa

### 1. Buka Halaman Login
- Akses: `http://absensi-siswa.test/login`
- Atau: `http://localhost/absensi-siswa/public/login`
- Atau: `http://localhost:8000/login` (jika pakai `php artisan serve`)

### 2. Masukkan Kredensial
- **Email**: Email yang digunakan saat register
- **Password**: Password yang dibuat saat register
- **Ingat saya** (opsional): Centang jika ingin tetap login

### 3. Klik "Masuk"
- Jika berhasil → Redirect ke Dashboard Siswa
- Jika gagal → Cek email dan password

---

## 📋 Syarat Login Siswa

✅ **Harus sudah register terlebih dahulu**
- Buka: `http://absensi-siswa.test/register`
- Masukkan NIS yang sudah terdaftar
- Buat email dan password

✅ **Email dan password harus benar**
- Email harus sesuai dengan yang digunakan saat register
- Password harus sesuai (case-sensitive)

---

## 🎯 Setelah Login Berhasil

Siswa akan melihat:
- ✅ Dashboard Siswa dengan informasi pribadi
- ✅ NIS, Kelas, Status Absen Hari Ini
- ✅ Rekap Bulan Ini (Hadir, Izin, Sakit, Alpha)
- ✅ Riwayat Absensi Terbaru
- ✅ Panduan Scan QR Code

---

## 🔐 Jika Lupa Password

**Saat ini belum ada fitur reset password otomatis.**

**Solusi:**
1. Hubungi admin untuk reset password
2. Admin bisa reset via database atau artisan command

**Admin bisa reset dengan:**
```bash
php artisan tinker
```

Kemudian:
```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'email_siswa@email.com')->first();
$user->password = Hash::make('passwordbaru123');
$user->save();
```

---

## ⚠️ Troubleshooting

### Error: "Email atau password salah"
**Solusi:**
- Pastikan email benar (cek typo)
- Pastikan password benar (case-sensitive)
- Pastikan sudah register terlebih dahulu
- Coba clear browser cache

### Error: "Tidak bisa login"
**Solusi:**
- Pastikan sudah register dengan NIS yang valid
- Pastikan siswa sudah ditambahkan admin di "Data Siswa"
- Cek apakah akun masih aktif

### Setelah login, tidak redirect ke dashboard
**Solusi:**
- Refresh halaman
- Clear browser cache
- Coba logout dan login lagi

### Dashboard kosong atau error
**Solusi:**
- Pastikan data siswa lengkap (ada NIS, kelas, dll)
- Hubungi admin untuk memastikan data siswa benar
- Pastikan siswa memiliki kelas yang aktif

---

## 📱 Login via HP (Mobile)

Siswa juga bisa login menggunakan HP:
1. Buka browser di HP (Chrome, Firefox, Safari, dll)
2. Akses: `http://absensi-siswa.test/login`
3. Masukkan email dan password
4. Login berhasil → Dashboard siswa akan tampil di HP

**Keuntungan login via HP:**
- Bisa langsung scan QR code untuk absen
- Lebih mudah dan praktis
- Bisa absen langsung dari HP

---

## ✅ Checklist Sebelum Login

- [ ] Sudah register dengan NIS yang valid
- [ ] Ingat email yang digunakan saat register
- [ ] Ingat password yang dibuat
- [ ] NIS sudah ditambahkan admin di "Data Siswa"
- [ ] Koneksi internet aktif

---

## 🎓 Contoh Login

**Contoh jika sudah register:**
- Email: `siswa1@email.com`
- Password: `password123`

**Langkah:**
1. Buka `http://absensi-siswa.test/login`
2. Masukkan email: `siswa1@email.com`
3. Masukkan password: `password123`
4. Klik "Masuk"
5. ✅ Berhasil → Dashboard Siswa muncul

---

**Selamat menggunakan aplikasi!** 🎉

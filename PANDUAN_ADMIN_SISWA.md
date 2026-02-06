# Panduan Admin: Menambahkan Siswa Baru

Sebagai admin, Anda perlu menambahkan data siswa terlebih dahulu sebelum siswa bisa register. Berikut panduannya:

## 📋 Cara Menambahkan Siswa Baru

### Langkah-Langkah:

1. **Login sebagai Admin**
   - Email: `admin@absensi.test`
   - Password: `password` (atau password yang sudah diubah)

2. **Buka Menu "Data Siswa"**
   - Klik menu "Data Siswa" di sidebar
   - Atau akses: `http://absensi-siswa.test/siswa`

3. **Klik "Tambah Siswa"**
   - Tombol biasanya di kanan atas atau di bawah tabel

4. **Isi Form Data Siswa:**
   - **NIS** (wajib): Nomor Induk Siswa (harus unik)
     - Contoh: `20240001`, `20240002`, dll
     - ⚠️ NIS ini yang akan digunakan siswa untuk register
   - **Nama Lengkap** (wajib): Nama lengkap siswa
   - **Jenis Kelamin**: L (Laki-laki) atau P (Perempuan)
   - **Tempat Lahir**: Tempat lahir siswa
   - **Tanggal Lahir**: Tanggal lahir siswa
   - **Alamat**: Alamat siswa
   - **No. Telepon**: Nomor telepon siswa
   - **Email**: Email siswa (opsional)
   - **Kelas**: Pilih kelas siswa
   - **Status Aktif**: Centang jika siswa aktif

5. **Klik "Simpan"**
   - Data siswa akan tersimpan
   - Siswa sekarang bisa register menggunakan NIS tersebut

## ✅ Setelah Siswa Ditambahkan

Siswa dapat:
1. Buka halaman register: `http://absensi-siswa.test/register`
2. Masukkan NIS yang sudah Anda tambahkan
3. Masukkan email dan password
4. Register berhasil dan otomatis login

## 📝 Tips untuk Admin

### 1. NIS Harus Unik
- Setiap siswa harus memiliki NIS yang berbeda
- Sistem akan menolak jika NIS duplikat

### 2. Pastikan Kelas Sudah Ada
- Sebelum menambahkan siswa, pastikan kelas sudah dibuat
- Buka menu "Data Kelas" untuk menambahkan kelas baru

### 3. Status Aktif
- Hanya siswa dengan status aktif yang bisa register
- Nonaktifkan siswa jika sudah lulus atau pindah

### 4. Batch Import (Manual)
- Saat ini belum ada fitur import Excel
- Tambahkan siswa satu per satu atau gunakan seeder untuk data contoh

## 🔍 Cara Melihat Daftar Siswa

1. Buka menu "Data Siswa"
2. Tabel menampilkan:
   - NIS
   - Nama Lengkap
   - Kelas
   - Status (Aktif/Tidak Aktif)
   - Aksi (Edit/Hapus)

## ✏️ Edit Data Siswa

1. Klik tombol "Edit" pada siswa yang ingin diubah
2. Ubah data yang diperlukan
3. Klik "Simpan"
4. Data akan terupdate

## 🗑️ Hapus Siswa

1. Klik tombol "Hapus" pada siswa yang ingin dihapus
2. Konfirmasi penghapusan
3. ⚠️ Hati-hati: Jika siswa sudah memiliki akun, hapus akun terlebih dahulu

## 🔐 Reset Password Siswa

Jika siswa lupa password, admin bisa reset via database:

### Via Artisan Command:
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

### Via DBeaver:
1. Buka tabel `users`
2. Cari siswa berdasarkan email
3. Update kolom `password` dengan hash baru
4. Generate hash via tinker (lihat di atas)

## 📊 Data Siswa dari Seeder

Jika sudah menjalankan `php artisan db:seed`, ada 15 siswa contoh:
- NIS: `20240001` sampai `20240015`
- Semua siswa sudah memiliki kelas
- Status: Aktif

Siswa-siswa ini bisa langsung digunakan untuk testing register.

## ⚠️ Catatan Penting

1. **Siswa harus ditambahkan admin dulu** sebelum bisa register
2. **NIS adalah kunci** - Siswa harus tahu NIS mereka untuk register
3. **Satu NIS = Satu Akun** - Setiap NIS hanya bisa digunakan sekali untuk register
4. **Email harus unik** - Setiap siswa harus menggunakan email yang berbeda

## 🆘 Troubleshooting

### Siswa tidak bisa register dengan NIS tertentu
- Cek apakah NIS sudah ditambahkan di "Data Siswa"
- Pastikan status siswa "Aktif"
- Pastikan NIS yang dimasukkan benar (tanpa spasi)

### NIS sudah digunakan
- Cek apakah siswa sudah memiliki akun
- Lihat di tabel `users` dengan `siswa_id` yang sesuai
- Jika perlu, reset akun siswa tersebut

### Kelas tidak muncul saat tambah siswa
- Pastikan kelas sudah dibuat di menu "Data Kelas"
- Pastikan kelas memiliki status "Aktif"

---

**Selamat mengelola data siswa!** 👨‍💼

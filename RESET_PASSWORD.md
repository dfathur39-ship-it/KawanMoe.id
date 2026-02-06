# Cara Reset Password Admin - Absensi Siswa

## Solusi 1: Gunakan Kredensial Default

Jika Anda sudah menjalankan seeder, coba login dengan:

- **Email**: `admin@absensi.test`
- **Password**: `password`

## Solusi 2: Reset Password via Artisan Command

### Reset Password Admin yang Sudah Ada

```bash
php artisan admin:reset-password admin@absensi.test
```

Atau dengan password langsung:

```bash
php artisan admin:reset-password admin@absensi.test --password=passwordbaru123
```

### Buat Admin Baru

```bash
php artisan admin:create admin@email.com password123 --name="Nama Admin"
```

Contoh:
```bash
php artisan admin:create admin@sekolah.com admin123 --name="Admin Sekolah"
```

## Solusi 3: Reset Password via DBeaver (Database Langsung)

1. Buka DBeaver
2. Connect ke database `absensi_siswa`
3. Buka tabel `users`
4. Cari user dengan role `admin`
5. Edit kolom `password` dengan hash baru

**Generate hash password:**
Buka terminal Laravel dan jalankan:
```bash
php artisan tinker
```

Kemudian ketik:
```php
use Illuminate\Support\Facades\Hash;
echo Hash::make('passwordbaru123');
```

Copy hasil hash tersebut, lalu paste ke kolom `password` di DBeaver.

**Atau langsung update via SQL:**
```sql
UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE email = 'admin@absensi.test';
```

(Password di atas adalah hash untuk: `password`)

## Solusi 4: Reset Database (Hapus Semua Data)

**⚠️ PERINGATAN: Ini akan menghapus semua data!**

```bash
php artisan migrate:fresh --seed
```

Ini akan:
- Menghapus semua tabel
- Membuat ulang tabel
- Menjalankan seeder (membuat admin default)

Setelah ini, gunakan kredensial default:
- Email: `admin@absensi.test`
- Password: `password`

## Solusi 5: Lihat Semua User Admin

Untuk melihat semua admin yang terdaftar:

```bash
php artisan tinker
```

Kemudian:
```php
use App\Models\User;
User::where('role', 'admin')->get(['id', 'name', 'email']);
```

## Tips

1. **Simpan kredensial dengan aman** setelah reset
2. **Ganti password default** setelah pertama kali login
3. **Jangan share password** dengan orang lain
4. **Backup database** sebelum reset jika ada data penting

## Troubleshooting

**Command tidak ditemukan:**
- Pastikan sudah di folder project
- Clear cache: `php artisan config:clear`

**Error database:**
- Pastikan MySQL running di Laragon
- Cek koneksi database di `.env`

**Password tidak berfungsi:**
- Pastikan password di-hash dengan benar
- Coba reset ulang dengan command artisan

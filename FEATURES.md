# Daftar Fitur - Aplikasi Absensi Siswa

## ✅ Fitur yang Sudah Diimplementasikan

### 1. Autentikasi & Authorization
- ✅ Login untuk Admin dan Siswa
- ✅ Register hanya untuk Siswa (Admin tidak bisa register)
- ✅ Middleware role-based (CheckRole)
- ✅ Redirect ke dashboard setelah login
- ✅ Session management

### 2. Dashboard
- ✅ Dashboard Admin dengan statistik lengkap
- ✅ Dashboard Siswa dengan info personal
- ✅ Grafik absensi 7 hari terakhir (Admin)
- ✅ Live clock & tanggal
- ✅ Statistik real-time

### 3. Profil Data
- ✅ Halaman profil untuk semua user
- ✅ Edit nama dan email
- ✅ Update password
- ✅ Edit data siswa (no telepon, alamat) untuk siswa
- ✅ Tampilan profil dengan avatar

### 4. QR Code Absensi
- ✅ Admin dapat generate QR code
- ✅ QR code dengan token unik (expires 5 menit)
- ✅ Siswa scan QR code menggunakan kamera HP
- ✅ Auto-record absensi setelah scan
- ✅ Validasi: hanya siswa yang sudah login bisa scan
- ✅ Validasi: tidak bisa absen 2x dalam sehari

### 5. Manajemen Data (Admin Only)
- ✅ CRUD Kelas
- ✅ CRUD Siswa
- ✅ Input absensi manual
- ✅ Quick attendance (absensi cepat)
- ✅ Rekap absenan bulanan
- ✅ Rekap absensi tahunan

### 6. Laporan
- ✅ Download laporan PDF harian
- ✅ Download laporan PDF bulanan
- ✅ Download laporan PDF tahunan
- ✅ Filter berdasarkan kelas dan tanggal

### 7. UI/UX
- ✅ Design modern dengan Bootstrap 5
- ✅ Responsive (mobile-friendly)
- ✅ Sidebar navigation
- ✅ Color-coded badges untuk status absensi
- ✅ Alert notifications
- ✅ Loading states

## Struktur Aplikasi

### Controllers
- `AuthController` - Login, Register, Logout
- `DashboardController` - Dashboard Admin & Siswa
- `ProfileController` - Edit profil
- `QrAbsenController` - Generate & scan QR code
- `KelasController` - CRUD Kelas
- `SiswaController` - CRUD Siswa
- `AbsensiController` - Input & rekap absensi
- `ReportController` - Generate laporan PDF

### Models
- `User` - User authentication (admin/siswa)
- `Kelas` - Data kelas
- `Siswa` - Data siswa
- `Absensi` - Data absensi

### Middleware
- `CheckRole` - Validasi role (admin/siswa)
- `Authenticate` - Validasi login
- `RedirectIfAuthenticated` - Redirect jika sudah login

### Routes
- `/` - Redirect ke login
- `/login` - Halaman login
- `/register` - Halaman register (siswa only)
- `/dashboard` - Dashboard (berbeda untuk admin/siswa)
- `/profile` - Profil user
- `/qrabsen` - Generate QR code (admin)
- `/absen/scan/{token}` - Scan QR code (siswa)
- `/kelas` - CRUD Kelas (admin)
- `/siswa` - CRUD Siswa (admin)
- `/absensi` - Input absensi (admin)
- `/report` - Download laporan (admin)

## Database Schema

### users
- id, name, email, password, role
- siswa_id, kelas_id (untuk siswa)
- timestamps

### kelas
- id, nama_kelas, tingkat, jurusan
- wali_kelas, tahun_ajaran, is_active
- timestamps

### siswa
- id, nis (unique), nama_lengkap
- jenis_kelamin, tempat_lahir, tanggal_lahir
- alamat, no_telepon, email, foto
- kelas_id, is_active
- timestamps

### absensi
- id, siswa_id, kelas_id
- tanggal, waktu_masuk, waktu_pulang
- status (hadir/izin/sakit/alpha)
- keterangan, recorded_by
- timestamps
- unique: siswa_id + tanggal

## Security Features

- ✅ Password hashing (bcrypt)
- ✅ CSRF protection
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ Role-based access control
- ✅ Session security
- ✅ Token expiration untuk QR code

## Teknologi & Dependencies

- Laravel 10.x
- MySQL/MariaDB
- Bootstrap 5
- Chart.js (untuk grafik)
- QRCode.js (untuk generate QR)
- DomPDF (untuk generate PDF)

## Catatan Penting

1. **Admin tidak bisa register** - Admin hanya bisa login dengan akun yang sudah dibuat (via seeder)
2. **Siswa harus register dengan NIS** - NIS harus sudah terdaftar di database oleh admin
3. **QR Code expires** - Token QR code berlaku 5 menit
4. **Satu absensi per hari** - Setiap siswa hanya bisa absen sekali per hari
5. **Role-based access** - Setiap route dilindungi dengan middleware sesuai role

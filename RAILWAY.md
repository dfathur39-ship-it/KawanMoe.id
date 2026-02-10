# Deploy Absensi Siswa ke Railway

Panduan ini menjelaskan cara menghosting aplikasi Laravel **Absensi Siswa** di [Railway](https://railway.com).

---

## Persiapan

1. **Akun Railway** – Daftar di [railway.com](https://railway.com).
2. **Repo GitHub** – Push project ini ke GitHub (jika belum).
3. **Database** – Railway menyediakan MySQL (atau PostgreSQL). Aplikasi ini memakai MySQL.

---

## Langkah 1: Buat Project & Database

1. Buka [railway.com/new](https://railway.com/new).
2. Klik **Deploy from GitHub repo**.
3. Pilih repo **absensi-siswa** (atau nama repo Anda).
4. Di **Project Canvas**, tambah database:
   - Klik **+ New** → **Database** → **MySQL**.
   - Tunggu sampai MySQL service selesai deploy.
5. Catat nama service MySQL (misalnya `MySQL`). Nanti dipakai untuk referensi variabel.

---

## Langkah 2: Variabel Environment (Variables)

Di service **aplikasi** (bukan MySQL), buka **Variables** → **Raw Editor**, lalu isi variabel berikut.

### Wajib

| Variable       | Nilai | Keterangan |
|----------------|-------|------------|
| `APP_NAME`     | `Absensi Siswa` | Nama aplikasi |
| `APP_ENV`      | `production` | Environment |
| `APP_KEY`      | *(lihat bawah)* | Generate: `php artisan key:generate --show` (lokal), copy base64:... |
| `APP_DEBUG`    | `false` | **Harus false** di production |
| `APP_URL`      | `https://<domain-railway>.up.railway.app` | Ganti setelah Generate Domain (langkah 4) |

### Database (pakai MySQL dari Railway)

Pilih salah satu:

**Opsi A – Pakai referensi variabel Railway (disarankan)**

| Variable       | Nilai |
|----------------|--------|
| `DATABASE_URL` | `${{MySQL.MYSQL_URL}}` |

*(Ganti `MySQL` dengan nama service MySQL Anda di Railway.)*

**Opsi B – Isi manual**

| Variable       | Nilai |
|----------------|--------|
| `DB_CONNECTION` | `mysql` |
| `DB_HOST`      | `${{MySQL.MYSQLHOST}}` |
| `DB_PORT`      | `${{MySQL.MYSQLPORT}}` |
| `DB_DATABASE`  | `${{MySQL.MYSQLDATABASE}}` |
| `DB_USERNAME`  | `${{MySQL.MYSQLUSER}}` |
| `DB_PASSWORD`  | `${{MySQL.MYSQLPASSWORD}}` |

### Log (agar log muncul di Railway)

| Variable             | Nilai |
|----------------------|--------|
| `LOG_CHANNEL`        | `stderr` |
| `LOG_STDERR_FORMATTER` | `Monolog\Formatter\JsonFormatter` |

### Lainnya (boleh default)

| Variable            | Nilai (contoh) |
|---------------------|----------------|
| `CACHE_DRIVER`      | `file` |
| `SESSION_DRIVER`    | `file` |
| `QUEUE_CONNECTION`  | `sync` |

---

## Langkah 3: Pre-Deploy Command (migrasi & cache)

Agar setiap deploy menjalankan migrasi dan cache config:

1. Di service aplikasi, buka **Settings**.
2. Di **Deploy** → **Pre-Deploy Command** isi:
   ```bash
   chmod +x ./railway/init-app.sh && sh ./railway/init-app.sh
   ```
3. Simpan.

Script `railway/init-app.sh` akan:

- `php artisan migrate --force`
- `php artisan storage:link`
- `php artisan config:cache`
- `php artisan route:cache`
- `php artisan view:cache`

---

## Langkah 4: Domain & Deploy

1. Di service aplikasi, buka **Settings** → **Networking**.
2. Klik **Generate Domain**. Railway akan memberi URL seperti `xxx.up.railway.app`.
3. Copy URL itu, lalu di **Variables** set:
   - `APP_URL` = `https://xxx.up.railway.app` (pakai **https**).
4. Klik **Deploy** (atau trigger deploy dari commit terbaru).

Setelah deploy sukses, buka URL domain tersebut. Jika ada error 500, cek **Logs** di Railway.

---

## Langkah 5: User admin pertama (opsional)

Setelah migrasi jalan, Anda bisa membuat admin lewat Railway shell:

1. Di service aplikasi → **Settings** → **Shell** (atau pakai **railway run**).
2. Jalankan:
   ```bash
   php artisan tinker
   ```
   Lalu di Tinker:
   ```php
   \App\Models\User::factory()->create(['email' => 'admin@example.com', 'role' => 'admin']);
   ```
   Atau jika ada custom command:
   ```bash
   php artisan create:admin
   ```

*(Sesuaikan dengan command yang ada di project Anda.)*

---

## Ringkasan file untuk Railway

| File / folder        | Fungsi |
|----------------------|--------|
| `nixpacks.toml`      | Root web ke `public/` (Nixpacks). |
| `railway/init-app.sh`| Script pre-deploy: migrasi, storage link, cache. |
| `Procfile`           | Tidak wajib; Railway pakai Nixpacks (php-fpm + nginx). |
| TrustProxies         | Sudah di-set `*` agar proxy Railway dipercaya. |

---

## Troubleshooting

- **500 / Application error**  
  Cek **Variables**: `APP_KEY` dan `DATABASE_URL` (atau `DB_*`) harus benar. Cek **Logs**.

- **Database connection refused**  
  Pastikan service MySQL sudah running dan variabel `DATABASE_URL` / `DB_*` mengarah ke service MySQL (referensi `${{MySQL.MYSQL_URL}}` atau yang setara).

- **CSS/JS tidak load**  
  Pastikan build frontend jalan: Nixpacks akan jalankan `npm run build` jika ada `package.json` dan script `build`. Cek **Build logs**.

- **Session / login hilang**  
  Pastikan `APP_URL` sama persis dengan URL yang dipakai user (termasuk `https://`).

---

## Referensi

- [Railway – Deploy a Laravel App](https://docs.railway.com/guides/laravel)
- [Railway – MySQL](https://docs.railway.com/databases/mysql)
- [Railway – Variables](https://docs.railway.com/variables)

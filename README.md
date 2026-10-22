# SIGMA – Solusi Irit dan Gizi Maksimal

SIGMA adalah platform kurasi digital makanan mahasiswa. Aplikasi ini membantu mahasiswa menemukan hidangan lezat dan bergizi di sekitar kampus tanpa menguras dompet, sekaligus menjadi wadah bagi UMKM kantin/warung sekitar kampus untuk tampil dan mengelola menunya.

## Fitur

- **Beranda & Pencarian Menu** – kurasi menu makanan dengan filter kategori, harga, dan gizi.
- **Profil UMKM** – halaman profil lengkap untuk setiap UMKM (deskripsi, fasilitas, jam operasional, menu).
- **Pendaftaran UMKM** – UMKM baru dapat mendaftar, lalu disetujui (approval) oleh admin sebelum tampil publik.
- **Asisten Gizi (AI Chatbot)** – chatbot berbasis Gemini untuk konsultasi gizi dan rekomendasi menu sesuai budget.
- **Scanner Nutrisi (AI Vision)** – mitra mengunggah foto makanan, AI mendeteksi nama makanan dan mengisi nutrisi (kalori, protein, lemak) secara otomatis.
- **Dashboard Admin** – approval UMKM, monitoring menu, fitur/unfitur menu unggulan, dan analitik.
- **Dashboard Mitra** – kelola menu (tambah/edit/hapus + badge), profil UMKM, dan analitik penjualan.

## Tech Stack

- [Laravel 12](https://laravel.com) (PHP >= 8.2)
- Blade templating + Tailwind CSS (via Vite)
- SQLite (default, tanpa perlu install MySQL) – bisa diganti MySQL/PostgreSQL lewat `.env`
- Gemini API untuk fitur AI (opsional)

## Prasyarat

Pastikan di komputermu sudah terinstall:

- **PHP >= 8.2** (dengan ekstensi `pdo_sqlite`, `fileinfo`, `gd` atau `imagick`, `openssl`)
- **Composer** – [cara install](https://getcomposer.org/download/)
- **Node.js >= 20** + **npm** – [cara install](https://nodejs.org/)
- (Opsional) **Laragon/XAMPP** di Windows untuk PHP & MySQL sekalian

Cek dengan perintah:

```bash
php --version      # harus >= 8.2
composer --version
node --version     # harus >= 20
npm --version
```

## Cara Menjalankan (Setup dari Nol)

Ikuti langkah-langkah berikut **secara berurutan** di root project:

### 1. Install dependency PHP

```bash
composer install
```

### 2. Buat file environment

```bash
# Windows (PowerShell)
copy .env.example .env

# Linux / macOS
cp .env.example .env
```

### 3. Generate application key

```bash
php artisan key:generate
```

### 4. Jalankan migrasi database + data contoh (seed)

Project ini memakai **SQLite** secara default, jadi tidak perlu setup MySQL.

```bash
php artisan migrate --seed
```

Perintah ini otomatis membuat tabel-tabel database dan mengisi data contoh: admin, akun mitra, UMKM, kategori, menu, dan review.

### 5. Siapkan file gambar & storage link

Gambar menu/UMKM yang dirujuk seeder tersimpan di `public/images`, sedangkan aplikasi menyajikannya via `storage`. Salin dulu gambarnya, lalu buat symbolic link:

```bash
# Windows (PowerShell)
New-Item -ItemType Directory -Force -Path storage/app/public/images/menus, storage/app/public/images/umkm
Copy-Item public/images/menus/* storage/app/public/images/menus/
Copy-Item public/images/umkm/* storage/app/public/images/umkm/

# Linux / macOS
mkdir -p storage/app/public/images/menus storage/app/public/images/umkm
cp public/images/menus/* storage/app/public/images/menus/
cp public/images/umkm/* storage/app/public/images/umkm/
```

Lalu:

```bash
php artisan storage:link
```

> `storage:link` hanya perlu dijalankan sekali. Di Windows jalankan sebagai Administrator bila gagal.

### 6. Install dependency frontend & build asset

```bash
npm install
npm run build
```

### 7. Jalankan server

```bash
php artisan serve
```

Buka **http://localhost:8000** di browser. Selesai! 🎉

### (Alternatif) Mode Development

Kalau mau development dengan hot-reload untuk CSS/JS, jalankan **dua terminal**:

```bash
# Terminal 1 – server Laravel
php artisan serve

# Terminal 2 – Vite dev server
npm run dev
```

## Akun Contoh (Data Seed)

| Nama | Email | Password | Role |
|------|-------|----------|------|
| Admin SIGMA | `admin@sigma.com` | `admin123456` | Admin |
| Mitra Ibu Haji | `mitra1@example.com` | `password123` | Mitra (Warung Ibu Haji) |
| Mitra Bude Sari | `mitra2@example.com` | `password123` | Mitra (Bakso Bude Sari) |
| Mitra Kopi Kaki Lima | `mitra3@example.com` | `password123` | Mitra (Kopi Kaki Lima) |

- Login admin: **http://localhost:8000/login** (pilih role *Admin*)
- Login mitra: **http://localhost:8000/login** (pilih role *Mitra*)

## Konfigurasi Fitur AI (Opsional)

Fitur **Asisten Gizi** dan **Scanner Nutrisi** memakai Gemini API. Tanpa API key, aplikasi tetap jalan – chatbot otomatis memakai jawaban fallback dan scanner akan gagal menganalisis foto.

Cara aktifkan:

1. Ambil API key gratis di [Google AI Studio](https://aistudio.google.com/app/apikey).
2. Buka file `.env`, isi:

```env
GEMINI_API_KEY=isi_api_key_kamu_di_sini
```

3. Restart server (`php artisan serve`).

## Menggunakan MySQL (Opsional)

Secara default project memakai SQLite (`database/database.sqlite`). Kalau mau pakai MySQL:

1. Buat database kosong, contoh: `sigma`.
2. Edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sigma
DB_USERNAME=root
DB_PASSWORD=
```

3. Hapus file `database/database.sqlite` (opsional), lalu jalankan ulang `php artisan migrate --seed`.

## Struktur Folder Penting

```
app/
├── Http/Controllers/     # Controller (Auth, Admin, Mitra, Chatbot, Scanner, dll)
├── Models/               # Eloquent models (User, Umkm, Menu, Review, dll)
└── Services/             # Logika AI (NutritionScannerService, NutrisiService)
database/
├── migrations/          # Skema database
└── seeders/              # Data contoh
public/
├── css/  js/             # Asset statis custom
└── images/               # Sumber gambar (disalin ke storage saat setup)
resources/views/          # Blade templates (pages, layouts, partials, auth)
routes/web.php            # Definisi semua route
```

## Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Halaman putih / error 500 | Jalankan `php artisan key:generate`, pastikan `.env` ada |
| Gambar menu tidak muncul (404) | Ulangi **langkah 5** (salin gambar + `storage:link`) |
| Menu/UMKM kosong | Jalankan `php artisan db:seed` |
| `php artisan serve` port bentrok | Jalankan di port lain: `php artisan serve --port=8080` |
| Chatbot menjawab generik | Isi `GEMINI_API_KEY` di `.env` (lihat bagian Konfigurasi AI) |
| Error saat `npm run build` | Hapus `node_modules` lalu `npm install` ulang |

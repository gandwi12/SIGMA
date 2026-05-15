# SIGMA Project - UMKM Makanan AI Integration

Project ini adalah aplikasi berbasis Laravel 11 untuk UMKM makanan yang telah diintegrasikan dengan teknologi **Google Gemini AI**. Terdapat dua fitur utama AI yang tersedia di dalam project ini:
1. **AI Chatbot Rekomendasi Makanan** - Chatbot yang merekomendasikan menu makanan dari database sesuai dengan preferensi user.
2. **AI Food Calorie Scanner** - Pendeteksi jenis makanan dan kalori otomatis berdasarkan upload foto/gambar.

---

## 🚀 Panduan Setup & Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan project ini di komputer Anda (Local Environment).

### 1. Kebutuhan Sistem (Prerequisites)
Pastikan Anda sudah menginstal aplikasi berikut:
- PHP 8.2 atau lebih baru
- Composer
- Database (SQLite/MySQL - *Project ini dikonfigurasi default menggunakan SQLite*)
- Akun Google (Untuk mendapatkan API Key Gemini)

### 2. Instalasi Project
Buka terminal Anda, masuk ke dalam folder project ini, dan jalankan perintah:

```bash
# 1. Install semua dependency Laravel
composer install

# 2. Salin file environment
cp .env.example .env

# 3. Generate Application Key
php artisan key:generate
```

### 3. Konfigurasi Google Gemini API
Fitur AI tidak akan berjalan tanpa API Key. 

1. Kunjungi website **[Google AI Studio](https://aistudio.google.com/)**.
2. Login dengan akun Google Anda dan klik tombol **"Get API key"** atau **"Create API key"**.
3. Copy API Key yang Anda dapatkan (Misal: `AIzaSyXXXXXXXXXX`).
4. Buka file `.env` di dalam project Anda.
5. Tambahkan kode berikut di baris paling bawah pada file `.env`:

```env
GEMINI_API_KEY=Taruh_API_Key_Anda_Disini
```

*(Catatan: Jangan tambahkan tanda kutip pada API key jika tidak perlu)*

### 4. Setup Database & Data Makanan
Agar chatbot AI bisa mengenali dan merekomendasikan daftar makanan Anda, jalankan migrasi dan seeder yang telah disiapkan:

```bash
# Perintah ini akan membuat tabel 'food' dan mengisi data makanan dummy (Nasi Goreng, Salad, dll)
php artisan migrate --seed --seeder=FoodSeeder
```

*(Catatan: Jika ditanya "Would you like to create it?" untuk database.sqlite, ketik `yes` dan enter)*

### 5. Menjalankan Aplikasi
Setelah semuanya selesai, nyalakan local server Laravel:

```bash
php artisan serve
```

Aplikasi sekarang dapat diakses melalui browser di alamat: `http://localhost:8000`

---

## 🧪 Cara Testing Fitur AI

Karena ini adalah integrasi backend ke existing template, sebuah view demo interaktif telah dibuat. 

### A. Testing Komponen Frontend
Buka file `resources/views/ai-features.blade.php`. Ini adalah *snippet* HTML & JavaScript yang bisa Anda paste ke dalam template utama website Anda (Misalnya di file `resources/views/welcome.blade.php`).

Jika Anda ingin melihat cara kerjanya secara langsung dari file demo:
1. Buka `routes/web.php`
2. Ubah `return view('welcome');` menjadi `return view('ai-features');`
3. Buka `http://localhost:8000` di browser.

### B. Testing Chatbot AI
- Di dalam form Chatbot, ketik kalimat seperti: *"Halo, saya lagi diet nih, ada makanan yang rendah kalori dan agak manis?"*
- Klik **Kirim**.
- AI akan memberikan jawaban natural dan merekomendasikan makanan (seperti *Salad Buah Segar* atau *Smoothie*) lengkap dengan harga dan estimasi kalori dari database lokal.

### C. Testing Food Scanner AI
- Scroll ke bagian Food Scanner.
- Klik **Choose File** / Upload Foto. Pilih gambar makanan (Contoh: foto pisang goreng atau burger format .jpg/.png maksimal 5MB).
- Klik **Scan Makanan**.
- Tunggu proses deteksi (kurang lebih 3-5 detik). AI Vision akan mengembalikan respon berupa **Nama Makanan**, **Estimasi Kalori**, **Confidence Level**, dan **Deskripsi Singkat**.

---

## 📁 Struktur File AI (Untuk Pembelajaran)
Bagi mahasiswa yang ingin mempelajari kode AI, silakan cek file-file berikut:
1. **Inti Komunikasi API:** `app/Services/GeminiService.php` (Berisi integrasi CURL/Http Request ke Google Endpoint).
2. **Prompt Engineering Chatbot:** `app/Services/ChatbotService.php` (Cara menyuruh AI mengambil data DB).
3. **Prompt Engineering Scanner:** `app/Services/FoodScannerService.php` (Cara mengirim gambar Base64 ke AI).
4. **Endpoint Controllers:** `app/Http/Controllers/ChatbotController.php` & `FoodScannerController.php`.

Selamat mengembangkan fitur AI di Web UMKM Anda! 🚀

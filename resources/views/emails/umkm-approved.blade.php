@component('mail::message')
# ✅ Akun UMKM Anda Telah Disetujui!

Halo **{{ $umkm->nama_usaha }}**,

Selamat! Pendaftaran UMKM Anda telah **disetujui** oleh admin SIGMA. Akun Anda sudah siap digunakan.

## 📋 Kredensial Login

| | |
|---|---|
| **Email** | `{{ $umkm->email }}` |
| **Username** | `{{ $credentials['user']->name }}` |
| **Password** | `{{ $credentials['password'] }}` |

@component('mail::button', ['url' => config('app.url') . '/login'])
Login Ke Dashboard
@endcomponent

## 📝 Langkah Selanjutnya

1. Login menggunakan kredensial di atas
2. Lengkapi profil UMKM Anda (foto, deskripsi, dll)
3. Kelola produk/layanan Anda
4. Monitor rating dan ulasan pelanggan

## ⚠️ Keamanan

- **Jangan bagikan password** ini kepada siapa pun
- Ubah password Anda segera setelah login pertama kali
- Gunakan password yang kuat dan unik

Jika ada pertanyaan atau masalah, hubungi tim support kami melalui WhatsApp atau email.

---

Terima kasih telah bergabung dengan **SIGMA**! 🎉

Salam,  
**Tim SIGMA**

@endcomponent

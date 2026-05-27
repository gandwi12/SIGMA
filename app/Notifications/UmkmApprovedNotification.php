<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UmkmApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $umkm;
    private $credentials;

    public function __construct($umkm, $credentials)
    {
        $this->umkm = $umkm;
        $this->credentials = $credentials;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Selamat! UMKM Anda Disetujui - SIGMA')
            ->greeting("Halo {$this->umkm->pemilik},")
            ->line("Pendaftaran UMKM **{$this->umkm->nama_usaha}** telah disetujui oleh admin SIGMA! 🎉")
            ->line('')
            ->line('Berikut adalah kredensial akun Anda untuk login:')
            ->line('')
            ->line('📧 **Email:** ' . $this->umkm->email)
            ->line('👤 **Username:** `' . $this->credentials['user']->name . '`')
            ->line('🔐 **Password:** `' . $this->credentials['password'] . '`')
            ->line('')
            ->line('⚠️ **PENTING:**')
            ->line('- Jangan bagikan password ke siapa pun')
            ->line('- Simpan kredensial ini di tempat yang aman')
            ->line('- Anda bisa mengubah password setelah login')
            ->action('Login Sekarang', route('login'))
            ->line('')
            ->line('Jika ada pertanyaan, hubungi tim support SIGMA.')
            ->salutation('Salam,
Tim SIGMA');
    }
}
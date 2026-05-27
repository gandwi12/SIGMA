<?php

namespace App\Mail;

use App\Models\Umkm;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UmkmApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Umkm $umkm,
        public array $credentials
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Akun UMKM Anda Telah Disetujui',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.umkm-approved',
            with: [
                'umkm' => $this->umkm,
                'credentials' => $this->credentials,
            ],
        );
    }
}
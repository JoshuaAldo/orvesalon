<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $whatsappMessage;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->whatsappMessage = rawurlencode(
            "Halo, Pembayaran order berikut telah terkonfirmasi mohon segera atur jadwal hairdresser.\n" .
                "ID: {$booking->id}\n" .
                "Nama: {$booking->name}\n" .
                "Layanan: {$booking->service->name}\n" .
                "Jadwal: {$booking->schedule->available_at}\n" .
                "Alamat: {$booking->address}\n" .
                "Email: {$booking->email}\n" .
                "Nomer Whatsapp: {$booking->phone}\n" .
                "Total: Rp " . number_format($booking->price, 0, ',', '.') . "\n" .
                "Terima Kasih"
        );
    }

    public function build()
    {
        return $this->subject('Notifikasi Booking Baru #' . $this->booking->id)
            ->view('emails.admin_notification')
            ->with([
                'booking' => $this->booking,
                'wa_message' => $this->whatsappMessage
            ]);
    }
}

<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendSaleNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $sale;
    protected $email;
    public function __construct($sale, $email)
    {
        $this->email = $email;
        $this->sale = $sale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::where('email', $this->email)->first();
        return $this->subject('Notifikasi Penjualan')->view('emails.sale_notif', ['sale' => $this->sale, 'user' => $user]);
    }
}

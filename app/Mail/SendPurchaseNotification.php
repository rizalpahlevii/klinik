<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPurchaseNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $purchase;
    protected $email;
    public function __construct($purchase, $email)
    {
        $this->email = $email;
        $this->purchase = $purchase;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::where('email', $this->email)->first();
        return $this->subject('Notifikasi Pembelian')->view('emails.purchase_notif', ['purchase' => $this->purchase, 'user' => $user]);
    }
}

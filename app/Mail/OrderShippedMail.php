<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderShippedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $trackingCode;

    public function __construct(Order $order, $trackingCode = null)
    {
        $this->order = $order;
        $this->trackingCode = $trackingCode;
    }

    public function build()
    {
        return $this->subject('Seu pedido Vovó Lu Crochê foi enviado! #' . $this->order->id)
                    ->view('emails.shipped');
    }
}

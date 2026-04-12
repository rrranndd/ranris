<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderMail extends Mailable
{
    public $order;
    public $items;

    public function __construct($order, $items)
    {
        $this->order = $order;
        $this->items = $items;
    }

    public function build()
    {
        return $this->subject('Pesanan Baru Masuk')
                    ->view('emails.order');
    }
}
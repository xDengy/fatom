<?php

namespace App\Mail\Order;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewOrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this
            ->from('notify@umax.agency', 'Fatom')
            ->to('v.topalek@gmail.com')
            ->subject('Новый заказ с Fatom')
            ->view('mails.order.new.admin', ['order' => $this->order]);
    }
}

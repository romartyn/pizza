<?php

namespace App\Services;

use App\Presenters\OrderMailPresenter;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailService
{
    static public function sendOrder($order)
    {
        $presenter = new OrderMailPresenter($order);
        $order_presented = $presenter->makeData();

        // dispatch(function () use ($order_presented, $order) {
            Mail::send(
                'mail.order',
                $order_presented,
                function ($message) use ($order) {
                    $message
                        ->to($order->email, $order->name)
                        ->subject("Pizza Order #{$order->id}");
                }
            );
        // });
    }

}

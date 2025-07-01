<?php

namespace App\Listeners;

use App\Notifications\newCompleteExchangeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class sendCompleteExchangeNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
        $product = $event->product;
        $offer = $event->offer;
        $notifiables = [$product->user, $offer->user];
        Notification::send($notifiables, new newCompleteExchangeNotification($product, $offer));
    }
}

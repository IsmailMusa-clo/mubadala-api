<?php

namespace App\Listeners;

use App\Notifications\newOfferNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class sendAddOfferNotification
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
        $offer = $event->offer->load('product.user');
        $ownerProduct = $offer->product->user;
        Notification::send($ownerProduct, new newOfferNotification($offer));
    }
}

<?php

namespace App\Listeners;

use App\Notifications\newAcceptOfferNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class sendAcceptOfferNotification
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
        $offer = $event->offer->load('product');
        $user = $offer->user;
        Notification::send($user, new newAcceptOfferNotification($offer));
    }
}

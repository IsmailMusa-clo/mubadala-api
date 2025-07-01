<?php

namespace App\Listeners;

use App\Notifications\newMessageSendNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class sendMessageSendNotification
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
        $message = $event->message->load('sender', 'chat');
        $chat = $message->chat;
        $reciverUser = $chat->receiver;
        Notification::send($reciverUser, new newMessageSendNotification($message));
    }
}

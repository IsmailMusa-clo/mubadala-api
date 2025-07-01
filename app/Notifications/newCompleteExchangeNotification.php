<?php

namespace App\Notifications;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class newCompleteExchangeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Product $product, public Offer $offer)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }


    public function toDatabase(object $notifiable): DatabaseMessage
    {
        $offer = $this->offer;
        $product = $this->product;
        return new DatabaseMessage([
            'title' => 'اكتمال المبادلة',
            'body' => 'تم إكمال عملية مبادلة "' . $product->name . '". قم بتقييم الطرف الآخر.',
            'offer_id' => $offer->id,
            'product_id' => $product->id,
            'type' => 'complete-exchange'
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

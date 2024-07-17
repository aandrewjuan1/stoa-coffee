<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\OrderPlaced as OrderNotification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderNotification
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
    public function handle(OrderPlaced $event): void
    {
        //
        $order = $event->order;
        $user = User::find($order->user_id);

        // Send the email notification
        Notification::send($user, new OrderNotification($order));
    }
}

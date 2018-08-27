<?php

namespace App\Listeners;

use App\Events\PhotosUploaded;
use App\Order;

class PhotosUploadedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PhotosUploaded  $event
     * @return void
     */
    public function handle(PhotosUploaded $event)
    {
        $user = $event->user;

        $order = new Order;
        $order->user_id = $user->id;
        $order->status_id = 1;
        $order->save();
    }
}

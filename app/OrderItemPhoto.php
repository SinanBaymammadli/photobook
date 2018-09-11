<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItemPhoto extends Model
{
    public function order_item()
    {
        return $this->belongsTo('App\OrderItem');
    }
}

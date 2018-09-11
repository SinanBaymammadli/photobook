<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\OrderStatus');
    }

    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }
}

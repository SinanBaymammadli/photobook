<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function photos()
    {
        return $this->hasMany('App\OrderItemPhoto');
    }

    public function product_type()
    {
        return $this->belongsTo('App\ProductType');
    }
}

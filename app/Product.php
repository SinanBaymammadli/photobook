<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function types()
    {
        return $this->hasMany('App\ProductType');
    }

    public function photos()
    {
        return $this->hasMany('App\ProductPhoto');
    }
}

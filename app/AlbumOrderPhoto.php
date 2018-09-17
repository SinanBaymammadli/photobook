<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumOrderPhoto extends Model
{
    public function albumOrder()
    {
        return $this->belongsTo('App\AlbumOrder');
    }
}

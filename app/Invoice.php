<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $casts = [
        'total' => 'float',
    ];

    public function booking(){
        return $this->belongsTo('App\Booking');
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function room(){
        return $this->belongsTo('App\Room');
    }

    public function user(){
        return $this->belongsTo('App\User')->withTrashed();;
    }

    public function invoice(){
        return $this->hasOne('App\Invoice');
    }
}

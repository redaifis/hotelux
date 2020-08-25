<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function room(){
        return $this->belongsTo('App\Room');
    }

    protected $casts = [
        'is_approved' => 'boolean'
    ];
}

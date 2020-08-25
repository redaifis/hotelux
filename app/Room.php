<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'images' => 'array',
        'price' => 'float'
    ];

    public function bookings(){
        return $this->hasMany('App\Booking');
    }

    public function reviews(){
        return $this->hasMany('App\Review');
    }

    public function recommanded(){
        return $this->whereHas('reviews', function($q){
            return $q->where('rating', '>=', 4);
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

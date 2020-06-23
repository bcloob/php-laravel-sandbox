<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;


    public $fillable = [
        'API_KEY',
        'sandbox',
        'name',
        'phone_number',
        'email',
        'amount',
        'reseller',
        'status',
    ];


    public function get_Activity()
    {
        return $this->hasMany('App\Activity', 'order_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'state',
        'user_id',
        'city',
        'first_name',
        'last_name',
        'phone',
        'cart',
        'delivery_fee',
        'delivery_type',
        'total_price',
        'delivery_time_max',
        'delivery_time_min',
        'payment_type',
        'payment_status',
        'delivery_status',
        'order_status',
        'order_code'
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

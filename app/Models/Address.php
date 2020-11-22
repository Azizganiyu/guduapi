<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
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
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

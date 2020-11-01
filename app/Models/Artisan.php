<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artisan extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'first_name',
        'last_name',
        'username',
        'email',
        'gender',
        'image',
        'phone',
        'phone_operator',
        'city',
        'address',
        'about',
        'status'
    ];

    public function job(){
        return $this->hasOne(job::class, 'id', 'job_id');
    }
}

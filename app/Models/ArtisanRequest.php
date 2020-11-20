<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtisanRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'description',
        'address',
        'landmark',
        'phone',
        'state',
        'city'
    ];

    public function job(){
        return $this->hasOne(job::class, 'id', 'job_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}

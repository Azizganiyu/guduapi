<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo_url'
    ];

    public function make(){
        return $this->hasMany(Make::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}

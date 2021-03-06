<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Make extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id'
    ];

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}

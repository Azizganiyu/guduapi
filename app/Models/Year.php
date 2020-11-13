<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'modell_id',
        'year',
        'make_id',
        'category_id'
    ];

    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function make(){
        return $this->hasOne(Make::class, 'id', 'make_id');
    }

    public function modell(){
        return $this->hasOne(Modell::class, 'id', 'modell_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}

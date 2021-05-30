<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'modell_id',
        'part_id',
        'condition_id',
        'make_id',
        'name',
        'description',
        'meta_title',
        'meta_description',
        'width',
        'height',
        'weight',
        'depth',
        'discount',
        'quantity',
        'price',
        'tags',
        'status',
        'photo_url',
        'friendly_url',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function category(){
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    public function make(){
        return $this->hasOne(Make::class, 'id', 'make_id');
    }
    public function modell(){
        return $this->hasOne(Modell::class, 'id', 'modell_id');
    }
    public function condition(){
        return $this->hasOne(Condition::class, 'id', 'condition_id');
    }
    public function part(){
        return $this->hasOne(Part::class, 'id', 'part_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

}

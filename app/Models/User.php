<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'email',
        'password',
        'status',
        'photo_url',
        'username',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function jobs(){
        return $this->hasMany(job::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function makes(){
        return $this->hasMany(Make::class);
    }

    public function models(){
        return $this->hasMany(Modell::class);
    }

    public function conditions(){
        return $this->hasMany(Condition::class);
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function parts(){
        return $this->hasMany(Part::class);
    }

    public function cart(){
        return $this->hasOne(Cart::class);
    }

    public function address(){
        return $this->hasOne(Address::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}

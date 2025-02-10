<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;


    protected $fillable = [
        'city_id',
        'area_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'gender',
        'age',
        'full_address',
        'status',
        'image',
        'role',
        'floor_number',
        'apartment_number'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function user_identities()
    {
        return $this->hasMany(UserIdentity::class);
    }

    public function testproducts()
    {
        return $this->hasMany(TestProduct::class);
    }
}

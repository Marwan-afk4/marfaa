<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{


    protected $fillable = [
        'city_id',
        'name',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestProduct extends Model
{


    protected $fillable =[
        'user_id',
        'name',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

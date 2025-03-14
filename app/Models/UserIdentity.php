<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserIdentity extends Model
{


    protected $fillable =[
        'user_id',
        'identify_image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

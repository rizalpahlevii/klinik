<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    //

    protected $table = 'shifts';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

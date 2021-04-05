<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class CashierShift extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
            $model->current_stock = 0;
        });
    }
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }
}

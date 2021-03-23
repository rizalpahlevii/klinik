<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Sale extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
            $model->receipt_code = getUniqueString();
        });
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class, 'sale_id', 'id');
    }
}

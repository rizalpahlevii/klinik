<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class SupplierSalesman extends Model
{
    use SoftDeletes;

    protected $table = 'supplier_salesmans';

    protected $fillable = ['supplier_id', 'salesman_name', 'phone'];

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
}

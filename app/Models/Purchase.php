<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Purchase extends Model
{

    protected $fillable = ['receipt_code', 'receipt_date', 'receipt_photo_directory', 'supplier_id', 'salesman_id', 'sub_total', 'tax', 'discount', 'grand_total'];

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function salesman()
    {
        return $this->belongsTo(SupplierSalesman::class, 'salesman_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Purchase
 *
 * @property string $id
 * @property string $receipt_code
 * @property string $receipt_date
 * @property string $receipt_photo_directory
 * @property string $supplier_id
 * @property string $salesman_id
 * @property float $sub_total
 * @property float $tax
 * @property float $discount
 * @property float $grand_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseItem[] $purchaseItems
 * @property-read int|null $purchase_items_count
 * @property-read \App\Models\SupplierSalesman $salesman
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereReceiptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereReceiptDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereReceiptPhotoDirectory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSalesmanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

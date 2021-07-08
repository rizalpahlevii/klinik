<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Sale
 *
 * @property string $id
 * @property string $receipt_code
 * @property string $receipt_date
 * @property string $buyer_type
 * @property string $buyer_name
 * @property float $sub_total
 * @property float $tax
 * @property float $discount
 * @property float $grand_total
 * @property string|null $doctor_id
 * @property string $payment_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Medic|null $medic
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SaleItem[] $saleItems
 * @property-read int|null $sale_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newQuery()
 * @method static \Illuminate\Database\Query\Builder|Sale onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereBuyerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereBuyerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereDoctorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereGrandTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereReceiptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereReceiptDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Sale withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Sale withoutTrashed()
 * @mixin \Eloquent
 */
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

    public function medic()
    {
        return $this->belongsTo(Medic::class, 'doctor_id', 'id');
    }
}

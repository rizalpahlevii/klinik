<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Spending
 *
 * @property int $id
 * @property string $cashier_shift_id
 * @property string $name
 * @property string $amount
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CashierShift $shift
 * @method static \Illuminate\Database\Eloquent\Builder|Spending newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spending newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Spending query()
 * @method static \Illuminate\Database\Eloquent\Builder|Spending whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spending whereCashierShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spending whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spending whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spending whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spending whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Spending whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Spending extends Model
{
    public function shift()
    {
        return $this->belongsTo(CashierShift::class, 'cashier_shift_id', 'id');
    }
    protected $guarded = ['uuid', 'created_at', 'updated_at'];

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

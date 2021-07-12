<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\CashierShift
 *
 * @property string $id
 * @property string $cashier_id user id
 * @property string $start_shift
 * @property string|null $end_shift
 * @property float $initial_cash
 * @property float|null $shift_sales_total
 * @property float|null $final_cash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $cashier
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereEndShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereFinalCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereInitialCash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereShiftSalesTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereStartShift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $previous_shift_id
 * @method static \Illuminate\Database\Eloquent\Builder|CashierShift wherePreviousShiftId($value)
 */
class CashierShift extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashier_id', 'id');
    }

    public function cashAdds()
    {
        return $this->hasMany(ShiftCashAdd::class, 'cashier_shift_id', 'id');
    }
}

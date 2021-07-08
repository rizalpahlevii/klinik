<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\ShiftCassAdd
 *
 * @property int $id
 * @property string $cashier_id
 * @property string $cashier_shift_id
 * @property float $total_add
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd whereCashierShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd whereTotalAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCassAdd whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShiftCassAdd extends Model
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
}

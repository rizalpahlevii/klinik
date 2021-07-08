<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\ShiftCashTransfer
 *
 * @property int $id
 * @property string $cashier_id
 * @property string $cashier_shift_id
 * @property float $total_transfer
 * @property string|null $transfer_proof
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $transfer_amount
 * @property mixed $transfer_proof_image
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer whereCashierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer whereCashierShiftId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer whereTotalTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer whereTransferProof($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShiftCashTransfer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ShiftCashTransfer extends Model
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

    public function getTransferAmountAttribute()
    {
        $amount = $this->attributes['total_transfer'];

        return convertCurrency($amount);
    }

    public function setTransferProofImageAttribute($proof = null)
    {
        if (! $proof) $this->attributes['transfer_proof'] = null;

        $proof->move('upload/transfer-proof', $fileName);
        $fileName = time() . "_" . $proof->getClientOriginalName();

        $this->attributes['transfer_proof'] = $filename;
    }

    public function getTransferProofImageAttribute()
    {
        return asset($this->attributes['transfer_proof']);
    }
}

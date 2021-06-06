<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

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

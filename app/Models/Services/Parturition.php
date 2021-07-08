<?php

namespace App\Models\Services;

use App\Models\Medic;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Parturition extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($partus) {
            $partus->id = (string) Uuid::generate(4);
            $partus->service_number = getUniqueString();
        });

        self::saving(function ($partus) {
            $partus->total_fee = $partus->service_fee - $partus->discount;
        });
    }

    protected $table = 'parturition_services';

    public static $rules = [
        'registration_time' => 'required',
        'patient_id' => 'required',
        'medic_id' => 'required',
        'phone' => 'nullable',
        'fee' => 'required',
        'discount' => 'required',
        'notes' => 'nullable',
    ];

    public $fillable = [
        'service_number',
        'registration_time',
        'patient_id',
        'medic_id',
        'phone',
        'service_fee',
        'discount',
        'total_fee',
        'notes',
    ];

    public function setRawServiceFeeAttribute(string $fee)
    {
        $this->attributes['service_fee'] = convertCurrency($fee);
    }

    public function getFormattedServiceFeeAttribute()
    {
        return formatCurrency($this->attributes['service_fee']);
    }

    public function setRawDiscountAttribute(string $discount)
    {
        $this->attributes['discount'] = convertCurrency($discount);
    }

    public function getFormattedDiscountAttribute()
    {
        return formatCurrency($this->attributes['discount']);
    }

    public function medic()
    {
        return $this->belongsTo(Medic::class, 'medic_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}

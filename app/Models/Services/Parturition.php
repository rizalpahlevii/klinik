<?php

namespace App\Models\Services;

use App\Models\Medic;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Services\Parturition
 *
 * @property string $id
 * @property string $service_number
 * @property string $registration_time
 * @property string $patient_id
 * @property string $medic_id
 * @property string|null $phone
 * @property float $service_fee
 * @property float $discount
 * @property float $total_fee
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $formatted_discount
 * @property-read mixed $formatted_service_fee
 * @property-read Medic $medic
 * @property-read Patient $patient
 * @property-write mixed $raw_discount
 * @property-write mixed $raw_service_fee
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition query()
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereMedicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereRegistrationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereServiceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereServiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereTotalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $payment_method
 * @method static \Illuminate\Database\Eloquent\Builder|Parturition wherePaymentMethod($value)
 */
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
        'payment_method' => 'required'
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
        'payment_method'
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

<?php

namespace App\Models\Services;

use App\Models\Medic;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Services\General
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
 * @property-read Medic $medic
 * @property-read Patient $patient
 * @method static \Illuminate\Database\Eloquent\Builder|General newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|General newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|General query()
 * @method static \Illuminate\Database\Eloquent\Builder|General whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereMedicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereRegistrationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereServiceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereServiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereTotalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|General whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $payment_method
 * @method static \Illuminate\Database\Eloquent\Builder|General wherePaymentMethod($value)
 */
class General extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
            $model->service_number = getUniqueString();
        });
    }

    protected $table = 'general_services';

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

    public function medic()
    {
        return $this->belongsTo(Medic::class, 'medic_id', 'id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}

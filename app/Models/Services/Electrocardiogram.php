<?php

namespace App\Models\Services;

use App\Models\Medic;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Services\Electrocardiogram
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
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram query()
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereMedicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereRegistrationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereServiceFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereServiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereTotalFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electrocardiogram whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Electrocardiogram extends Model
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

    protected $table = 'electrocardiogram_services';

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

    public function medic()
    {
        return $this->belongsTo(Medic::class, 'medic_id', 'id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }
}

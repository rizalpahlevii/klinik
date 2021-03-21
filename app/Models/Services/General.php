<?php

namespace App\Models\Services;

use App\Models\Medic;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

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

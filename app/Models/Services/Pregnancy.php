<?php

namespace App\Models\Services;

use App\Models\Medic;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Pregnancy extends Model
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

    protected $table = 'pregnancy_services';

    public static $rules = [
        'service_number' => 'required|unique:pregnancy_services,service_number',
        'registration_time' => 'required',
        'patient_id' => 'required',
        'medic_id' => 'required',
        'phone' => 'required',
        'service_fee' => 'required|numeric',
        'discount' => 'required|numeric',
        'total_fee' => 'required|numeric',
        'notes' => 'required',
    ];

    public $fillable = [
        'service_number',
        'registration_time',
        'patient_id',
        'medic_id',
        'phone',
        'service_fee',
        'discount',
        'total_fe',
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

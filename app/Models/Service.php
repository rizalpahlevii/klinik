<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class Service
 * @package App\Models
 * @version February 25, 2020, 10:50 am UTC
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $quantity
 * @property int $rate
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereDeletedAt($value)
 * @method static Builder|Service whereDescription($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereName($value)
 * @method static Builder|Service whereQuantity($value)
 * @method static Builder|Service whereRate($value)
 * @method static Builder|Service whereStatus($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @mixin Model
 */
class Service extends Model
{

    public $table = 'services';

    public static $rules = [
        'service_number' => 'required|unique:services,service_number',
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
        'phone',
        'notes',
    ];
    public function medic()
    {
        return $this->belongsTo(Medic::class, 'medic_id', 'id');
    }
}

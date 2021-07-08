<?php

namespace App\Models;

use App\Models\Services\FamilyPlanning;
use App\Models\Services\General;
use App\Models\Services\Immunization;
use App\Models\Services\Laboratory;
use App\Models\Services\Parturition;
use App\Models\Services\Pregnancy;
use App\Models\Services\Administration;
use App\Models\Services\Electrocardiogram;
use App\Models\Services\Inpatient;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\Patient
 *
 * @property string $id
 * @property string $name
 * @property string $birth_date
 * @property string $phone
 * @property string $gender
 * @property string|null $blood_group
 * @property string $address
 * @property string $city
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Administration[] $administrationServices
 * @property-read int|null $administration_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Electrocardiogram[] $electrocardiogramServices
 * @property-read int|null $electrocardiogram_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|FamilyPlanning[] $familyPlanningServices
 * @property-read int|null $family_planning_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|General[] $generalServices
 * @property-read int|null $general_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Immunization[] $immunizationServices
 * @property-read int|null $immunization_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Inpatient[] $inpatientServices
 * @property-read int|null $inpatient_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Laboratory[] $laboratoryServices
 * @property-read int|null $laboratory_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Parturition[] $parturitionServices
 * @property-read int|null $parturition_services_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Pregnancy[] $pregnancyServices
 * @property-read int|null $pregnancy_services_count
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Query\Builder|Patient onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereBloodGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Patient withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Patient withoutTrashed()
 * @mixin \Eloquent
 */
class Patient extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'birth_date',
        'phone',
        'gender',
        'blood_group',
        'address',
        'city'
    ];
    public static $rules = [
        'name_form' => 'required|min:2',
        'birth_date' => 'required',
        'phone_form' => 'required',
        'gender_form' => 'required',
        'blood_group' => 'nullable',
        'address_form' => 'required|min:4',
        'city' => 'required:min:2'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }


    public function generalServices()
    {
        return $this->hasMany(General::class, 'patient_id', 'id');
    }

    public function familyPlanningServices()
    {
        return $this->hasMany(FamilyPlanning::class, 'patient_id', 'id');
    }

    public function laboratoryServices()
    {
        return $this->hasMany(Laboratory::class, 'patient_id', 'id');
    }

    public function pregnancyServices()
    {
        return $this->hasMany(Pregnancy::class, 'patient_id', 'id');
    }
    public function immunizationServices()
    {
        return $this->hasMany(Immunization::class, 'patient_id', 'id');
    }

    public function parturitionServices()
    {
        return $this->hasMany(Parturition::class, 'patient_id', 'id');
    }
    public function inpatientServices()
    {
        return $this->hasMany(Inpatient::class, 'patient_id', 'id');
    }
    public function electrocardiogramServices()
    {
        return $this->hasMany(Electrocardiogram::class, 'patient_id', 'id');
    }
    public function administrationServices()
    {
        return $this->hasMany(Administration::class, 'patient_id', 'id');
    }
}

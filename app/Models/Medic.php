<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medic extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'specialization',
        'birth_date',
        'phone',
        'gender',
        'blood_group',
        'address',
        'city'
    ];
    public static $rules = [
        'specialization' => 'required',
        'name_form' => 'required|min:2',
        'birth_date' => 'required',
        'phone_form' => 'required',
        'gender_form' => 'required',
        'blood_group' => 'required',
        'address_form' => 'required|min:4',
        'city' => 'required:min:2'
    ];
    public function services()
    {
        return $this->hasMany(Service::class, 'medic_id', 'id');
    }
}

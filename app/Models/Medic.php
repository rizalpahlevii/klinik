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
        'name' => 'required|min:2',
        'specialization' => 'required',
        'birth_date' => 'required',
        'phone' => 'required',
        'gender' => 'required',
        'blood_group' => 'required',
        'address' => 'required|min:4',
        'city' => 'required:min:2'
    ];
}

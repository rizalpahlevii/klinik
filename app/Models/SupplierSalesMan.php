<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierSalesman extends Model
{
    use SoftDeletes;

    protected $table = 'supplier_salesmans';

    protected $fillable = ['supplier_id', 'salesman_name', 'phone'];
}

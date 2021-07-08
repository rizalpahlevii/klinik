<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\SupplierSalesman
 *
 * @property string $id
 * @property string $supplier_id
 * @property string $salesman_name
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman newQuery()
 * @method static \Illuminate\Database\Query\Builder|SupplierSalesman onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman whereSalesmanName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupplierSalesman whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SupplierSalesman withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SupplierSalesman withoutTrashed()
 * @mixin \Eloquent
 */
class SupplierSalesman extends Model
{
    use SoftDeletes;

    protected $table = 'supplier_salesmans';

    protected $fillable = ['supplier_id', 'salesman_name', 'phone'];

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }
}

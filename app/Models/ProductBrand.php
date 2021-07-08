<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\ProductBrand
 *
 * @property string $id
 * @property string $brand_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductBrand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereBrandName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductBrand withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductBrand withoutTrashed()
 * @mixin \Eloquent
 */
class ProductBrand extends Model
{
    use SoftDeletes;

    protected $table = 'product_brands';

    protected $fillable = ['brand_name'];

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

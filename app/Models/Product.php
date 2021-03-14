<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class Product extends Model
{

    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'product_code',
        'name',
        'category_id',
        'brand_id',
        'unit',
        'selling_price',
        'current_stock',
        'total_minimum_stock',
        'side_effects',
        'notes'
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
            $model->product_code = self::productCode();
            $model->current_stock = 0;
        });
    }
    public static function productCode()
    {
        $cek = Product::where('product_code', 'like', 'PRF%')->get();
        if ($cek->count() > 0) {
            $product = Product::where('product_code', 'like', 'PRF%')->orderBy('id', 'DESC')->first();
            $nourut = (int) substr($product->product_code, -8, 8);
            $nourut++;
            $char = "PRF";
            $number = $char  .  sprintf("%08s", $nourut);
        } else {
            $number = "PRF"  . "00000001";
        }
        return $number;
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id', 'id');
    }
}

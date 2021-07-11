<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\StockAdjusment
 *
 * @property string $id
 * @property string $product_id
 * @property int $quantity
 * @property string|null $note
 * @property string $user_id
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Product $product
 * @property-read \App\Models\User|null $updatedBy
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment query()
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereUserId($value)
 * @mixin \Eloquent
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|StockAdjusment whereType($value)
 */
class StockAdjusment extends Model
{
    protected $fillable = ['product_id', 'user_id', 'note', 'quantity', 'updated_by', 'type'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
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

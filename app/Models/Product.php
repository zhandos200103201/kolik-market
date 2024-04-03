<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Collection\Collection;

/**
 * @property int $product_id
 * @property int $user_id
 * @property int $category_id
 * @property int $manufacturer_id
 * @property int $model_id
 * @property int $generation_id
 * @property string $name
 * @property string $description
 * @property string $photo
 * @property int $price
 * @property int|null $count
 * @property bool $is_used
 * @property int $views
 * @property float $score
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property-read Category|null $category
 * @property-read User|null $user
 * @property-read Manufacturer|null $manufacturer
 * @property-read CarModel|null $model
 * @property-read ModelGeneration|null $generation
 * @property-read Feedback[]|Collection $feedbacks
 */
final class Product extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'photo',
        'price',
        'count',
        'is_used',
        'category_id',
        'user_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'user_id' => 'integer',
        'category_id' => 'integer',
        'price' => 'integer',
        'count' => 'integer',
        'is_used' => 'boolean',
        'views' => 'integer',
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'category_id', 'category_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function manufacturer(): HasOne
    {
        return $this->hasOne(Manufacturer::class, 'manufacturer_id', 'manufacturer_id');
    }

    public function model(): HasOne
    {
        return $this->hasOne(CarModel::class, 'model_id', 'model_id');
    }

    public function generation(): HasOne
    {
        return $this->hasOne(ModelGeneration::class, 'generation_id', 'generation_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class, 'product_id', 'product_id');
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $service_id
 * @property int $category_id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $photo
 * @property int $price
 * @property int $views
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property-read Category|null $category
 * @property-read User|null $user
 */
class Service extends Model
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
    protected $table = 'services';

    /**
     * @var string
     */
    protected $primaryKey = 'service_id';

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
        'views',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'category_id' => 'integer',
        'price' => 'integer',
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
}

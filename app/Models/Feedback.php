<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $feedback_id
 * @property int|null $product_id
 * @property int|null $service_id
 * @property string $content
 * @property float $score
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property string|null $name
 * @property-read Product|null $product
 * @property-read Service|null $service
 */
class Feedback extends Model
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
    protected $table = 'feedback';

    /**
     * @var string
     */
    protected $primaryKey = 'feedback_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'score',
        'product_id',
        'service_id',
        'name',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'score' => 'float',
        'product_id' => 'integer',
        'service_id' => 'integer',
    ];

    public function service(): HasOne
    {
        return $this->hasOne(Service::class, 'service_id', 'service_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property-read Service[]|null $services
 */
final class Category extends Model
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
    protected $table = 'categories';

    /**
     * @var string
     */
    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'category_id', 'category_id');
    }
}

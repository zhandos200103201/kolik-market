<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $manufacturer_id
 * @property string $name
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property-read CarModel[]|null $carModels
 */
final class Manufacturer extends Model
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
    protected $table = 'manufacturers';

    /**
     * @var string
     */
    protected $primaryKey = 'manufacturer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function carModels(): HasMany
    {
        return $this->hasMany(CarModel::class, 'manufacturer_id', 'manufacturer_id');
    }
}

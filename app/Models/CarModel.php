<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $model_id
 * @property int $manufacturer_id
 * @property string $model_name
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property-read Manufacturer|null $manufacturer
 * @property-read ModelGeneration[]|null $generations
 */
final class CarModel extends Model
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
    protected $table = 'car_models';

    /**
     * @var string
     */
    protected $primaryKey = 'model_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'manufacturer_id',
        'model_name',
    ];

    public function manufacturer(): HasOne
    {
        return $this->hasOne(Manufacturer::class, 'manufacturer_id', 'manufacturer_id');
    }

    public function generations(): HasMany
    {
        return $this->hasMany(ModelGeneration::class, 'model_id', 'model_id');
    }
}

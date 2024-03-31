<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $generation_id
 * @property int|null $model_id
 * @property string $start_year
 * @property string $end_year
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property-read CarModel|null $carModel
 */
class ModelGeneration extends Model
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
    protected $table = 'model_generations';

    /**
     * @var string
     */
    protected $primaryKey = 'generation_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'model_id',
        'start_year',
        'end_year',
    ];

    public function carModel(): HasOne
    {
        return $this->hasOne(CarModel::class, 'model_id', 'model_id');
    }
}

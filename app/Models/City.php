<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $city_id
 * @property string $name
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property-read User[]|null $users
 */
final class City extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'cities';

    /**
     * @var string
     */
    protected $primaryKey = 'city_id';

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'user_id', 'user_id');
    }
}

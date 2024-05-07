<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $user_id
 * @property int $role_id
 * @property string $name
 * @property string $email
 * @property string|null $address
 * @property Carbon|string|null $email_verified_at
 * @property int $status
 * @property string $password
 * @property string|null $photo
 * @property string|null $remember_token
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $update_at
 * @property string|null $phone
 * @property-read Role[]|null $roles
 * @property-read Service[]|null $services
 */
final class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
    protected $table = 'users';

    /**
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'status',
        'address',
        'photo',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
        'role_id' => 'integer',
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'role_id', 'role_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'service_id', 'service_id');
    }
}

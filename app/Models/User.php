<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'role_id',
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
    ];

    /**
     * Get the vendors for the user.
     */
    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user's role is one of the listed roles.
     */
    public function hasRole(string $role): bool
    {
        return $this->role->name === $role;
    }

    /**
     * Check if the user's role is one of the listed roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role->name, $roles);
    }

    /**
     * Check if the user has a product.
     */
    public function hasProduct(int $product_id): bool
    {
        return $this::rightJoin('vendors', 'vendors.user_id', '=', 'users.id')
            ->rightJoin('products', 'vendors.id', '=', 'products.vendor_id')
            ->where(['products.id' => $product_id])
            ->where(['user_id' => $this->id])
            ->value('users.id')?true:false;
    }

    /**
     * Check if the user has the products.
     */
    public function hasProducts(): bool
    {
        return $this::rightJoin('vendors', 'vendors.user_id', '=', 'users.id')
            ->rightJoin('products', 'vendors.id', '=', 'products.vendor_id')
            ->where(['user_id' => $this->id])
            ->value('users.id')?true:false;
    }

    /**
     * return all products' ids.
     */
    public function products(): array
    {
        return $this::rightJoin('vendors', 'vendors.user_id', '=', 'users.id')
            ->rightJoin('products', 'vendors.id', '=', 'products.vendor_id')
            ->where(['user_id' => $this->id])
            ->value('users.id');
    }
}

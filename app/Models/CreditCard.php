<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditCard extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'card_number',
        'expiration_month',
        'expiration_year',
        'phone',
        'main'
    ];

    /**
     * Get the user that owns the credit-card.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

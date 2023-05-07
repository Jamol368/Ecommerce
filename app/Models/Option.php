<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'value'
    ];

    /**
     * The variants that belong to the option.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function variants()
    {
        return $this->belongsToMany(Variants::class, 'variant_options');
    }
}

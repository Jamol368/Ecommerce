<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOption extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_instance_id',
        'option_value_id'
    ];

    /**
     * Get the option value that owns the product option.
     */
    public function optionValue(): BelongsTo
    {
        return $this->belongsTo(OptionValue::class);
    }

    /**
     * Get the product intance that owns the product option.
     */
    public function productInstance(): BelongsTo
    {
        return $this->belongsTo(ProductInstance::class);
    }
}

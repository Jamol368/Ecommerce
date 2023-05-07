<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_code',
        'barcode',
        'active',
        'product_brand_id',
        'name',
        'description',
        'list_price',
        'price',
        'tax',
        'currency',
        'quantity',
        'in_discount',
        'detail'
    ];

    /**
     * The categories that belong to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    /**
     * The product brands that belong to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productBrand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    /**
     * The variants that belong to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    /**
     * The images that belong to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}

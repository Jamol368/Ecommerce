<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    public function topCategories()
    {
        return $this->hasMany(TopCategory::class);
    }

    public function subCategories()
    {
        return $this->hasManyThrough(SubCategory::class, TopCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

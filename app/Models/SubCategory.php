<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'top_category_id',
        'name',
        'slug',
    ];

    public function topCategory()
    {
        return $this->belongsTo(TopCategory::class);
    }
}

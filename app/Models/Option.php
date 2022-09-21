<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 *
 * @property Category[] $categories
 */
class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_options', 'option_id', 'category_id')
            ->withPivot(['active']);
    }
}

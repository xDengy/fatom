<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class CategoryOption extends Model
{
    use HasFactory, AsSource, Attachable, Filterable, Chartable;

    protected $fillable = [
        'category_id',
        'option_id',
        'active'
    ];

    /**
     * @var array
     */
    protected $allowedFilters = [
        'category_id',
        'option_id',
        'active'
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'category_id',
        'option_id',
        'active'
    ];
}

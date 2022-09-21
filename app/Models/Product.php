<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

/**
 * Class Product
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $seo_title
 * @property string $slug
 * @property string $description
 * @property string $seo_description
 * @property string $keywords
 * @property string $name
 * @property string $transliterated_name
 * @property string $price
 * @property string $price_title
 * @property string $image_path
 * @property string $image_alt
 * @property string $image_title
 * @property string $category_id
 * @property string $options
 * @property string $options_translited
 * @property string $opisanie
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Attachment[] $photos
 * @property Attachment $mainImg
 */
class Product extends Model
{
    use HasFactory, AsSource, Attachable, Filterable, Chartable;

    protected $fillable = [
        'seo_title',
        'slug',
        'seo_description',
        'keywords',
        'title',
        'price',
        'price_title',
        'image_path',
        'image_alt',
        'image_title',
        'category_id',
        'options',
        'options_translited',
        'description'
    ];

    /**
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'title',
        'category_id'
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'title',
        'category_id',
        'price_title'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function photos()
    {
        return $this->hasMany(Attachment::class)->where('group', 'photos');
    }

    public function mainImg()
    {
        return $this->hasOne(Attachment::class, 'id', 'hero')->withDefault();
    }
}

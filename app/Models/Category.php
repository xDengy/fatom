<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $title
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_h1
 * @property string $keywords
 * @property int $position
 * @property string $slug
 * @property string $has_products
 * @property string $image_path
 * @property string $image_title
 * @property string $image_alt
 * @property int $parent_id
 *
 * @property Category[] $ancestors  // The model's recursive parents.
 * @property Category[] $ancestorsAndSelf  // The model's recursive parents and itself.
 * @property Category[] $bloodline  // The model's ancestors, descendants and itself.
 * @property Category[] $children  // The model's direct children.
 * @property Category[] $childrenAndSelf  // The model's direct children and itself.
 * @property Category[] $descendants  // The model's recursive children.
 * @property Category[] $descendantsAndSelf  // The model's recursive children and itself.
 * @property Category[] $parent  // The model's direct parent.
 * @property Category[] $parentAndSelf  // The model's direct parent and itself.
 * @property Category[] $rootAncestor  // The model's topmost parent.
 * @property Category[] $siblings  // The parent's other children.
 * @property Category[] $siblingsAndSelf  // All the parent's children.
 * @property Attachment $mainImg
 * @property Attachment[] $photos
 */
class Category extends Model
{
    use HasFactory, AsSource, Attachable, Filterable, Chartable;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'has_products',
        'image_path',
        'image_title',
        'image_alt',
        'seo_title',
        'seo_description',
        'seo_h1',
        'keywords',
        'position',
    ];

    /**
     * @var array
     */
    protected $allowedFilters = [
        'title',
        'slug',
        'has_products',
        'id'
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'title',
        'has_products',
        'id'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    public function photos()
    {
        return $this->hasMany(Attachment::class)->where('group', 'photos');
    }

    public function mainImg()
    {
        return $this->hasOne(Attachment::class, 'id', 'hero')->withDefault();
    }

    public function options()
    {
        return $this->belongsToMany(
            Option::class,
            'category_options',
            'category_id',
            'option_id'
        )->withPivot(['active']);
    }

    public function activeOptions()
    {
        return $this->belongsToMany(
            Option::class,
            'category_options',
            'category_id',
            'option_id'
        )->where('active', true);
    }

    protected static function boot()
    {
        parent::boot();

        self::updating(function ($model) {
            /**@var Category $model */

            if (!$model->seo_title) {
                $model->seo_title = $model->title;
            }
            if (!$model->seo_h1) {
                $model->seo_h1 = $model->title;
            }
            if (!$model->seo_description) {
                $model->seo_description = $model->title;
            }
        });
    }

    public function scopeIsRoot($query)
    {
        return $query->where('parent_id', null);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function siblings()
    {
        return $this->hasMany(Category::class, 'parent_id', 'parent_id');
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public static function tree()
    {
        $allCategories = Category::orderBy('position')->get();
        $roots = $allCategories->whereNull('parent_id');
        self::formatTree($roots, $allCategories);
        return $roots;
    }

    private static function formatTree($categories, $allCategories)
    {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('parent_id', $category->id)->values();

            if ($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allCategories);
            }
        }
    }


}

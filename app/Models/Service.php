<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $title
 * @property string $transliterated_title
 * @property string $description
 * @property string $image_path
 * @property string $slug
 */
class Service extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'title',
        'preview_text',
        'description',
        'image_path',
        'slug',
        'SEO_text'
    ];
    public function photos(){
        return $this->hasMany(Attachment::class)->where('group','photos');
    }
    public function glimg(){
        return $this->hasOne(Attachment::class, 'id', 'hero')->withDefault();
    }
}

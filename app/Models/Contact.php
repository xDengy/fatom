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
 * @property string city
 * @property string address
 * @property string tel
 * @property string image_path
 * @property string geo
 *
 * @property Attachment $mainImg
 * @property Attachment[] $photos
 */
class Contact extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'city',
        'address',
        'tel',
        'image_path',
        'geo'
    ];

    public function photos()
    {
        return $this->hasMany(Attachment::class)->where('group', 'photos');
    }

    public function mainImg()
    {
        return $this->hasOne(Attachment::class, 'id', 'hero')->withDefault();
    }
}

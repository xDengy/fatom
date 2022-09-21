<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;


/**
 * @property string $page
 * @property string $page_url
 * @property string $h1
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $subtitle
 * @property string $fulldesc
 * @property string $phone
 * @property string $email
 * @property string $city
 * @property string $street
 * @property string $weekdays
 * @property string $weekend
 * @property string $link1
 * @property string $link2
 * @property string $link3
 * @property string $doptitle1
 * @property string $doptxt1
 * @property string $doptitle2
 * @property string $doptxt2
 * @property string $doptxt3
 * @property string $codkarti
 * @property string $codhtml
 * @property string $hero
 *
 *
 */
class SEO extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'page',
        'page_url',
        'h1',
        'title',
        'description',
        'keywords',
        'subtitle',
        'fulldesc',
        'phone',
        'email',
        'city',
        'street',
        'weekdays',
        'weekend',
        'link1',
        'link2',
        'link3',
        'doptitle1',
        'doptxt1',
        'doptitle2',
        'doptxt2',
        'doptxt3',
        'codkarti',
        'codhtml',
        'hero',
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

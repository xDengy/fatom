<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Settings extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'tel',
        'email',
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

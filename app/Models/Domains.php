<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Domains extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'domain',
        'domain_city',
        'domain_city_text',
        'tel',
        'tel2',
        'address'
    ];
}

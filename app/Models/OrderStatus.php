<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class OrderStatus extends Model
{
    use HasFactory, AsSource, Attachable, Filterable;

    protected $fillable = [
        'status',
        'value'
    ];
}

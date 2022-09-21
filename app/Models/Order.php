<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

class Order extends Model
{
    use HasFactory, AsSource, Attachable, Filterable, Chartable;

    public const STATUS_NEW = 'new';
    public const STATUS_PAID = 'paid';
    public const STATUS_SEND = 'send';
    public const STATUS_CANCELED = 'canceled';

    protected $fillable = [
        'email',
        'name',
        'tel',
        'message',
        'status',
        'delivery_id'
    ];

    /**
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'email',
        'name',
        'tel',
        'message',
        'status',
        'delivery_id'
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'email',
        'name',
        'tel',
        'message',
        'status',
        'delivery_id'
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'order_products',
            'order_id',
            'product_id'
        )->withPivot(['count', 'price']);
    }

    public static function getStatusList()
    {
        return [
            'new'      => 'Новый',
            'paid'     => 'Оплачен',
            'send'     => 'Отправлен',
            'canceled' => 'Отменен',
        ];
    }

    protected function getStatusNameAttribute(): string
    {
        return self::getStatusList()[$this->status];
    }
}

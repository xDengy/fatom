<?php

namespace App\Orchid\Layouts;

use App\Models\OrderStatus;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OrderStatusListLayout extends Table
{
    protected $target = 'order_status';
    protected function columns(): array
    {        
        return [
            TD::make('status', 'Статус')->render(function (OrderStatus $seo) {
                return Link::make($seo->status)->route('platform.order_status.editItem', $seo);
            }),
            TD::make('value', 'Значение'),
        ];
    }
}

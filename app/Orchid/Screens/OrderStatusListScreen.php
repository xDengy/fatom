<?php

namespace App\Orchid\Screens;

use App\Models\OrderStatus;
use App\Orchid\Layouts\OrderStatusListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class OrderStatusListScreen extends Screen
{
    public $name = 'Статус заказа';

    public function query(): array
    {
        return [
            'order_status' => OrderStatus::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.order_status.edit')
        ];
    }

    public function layout(): array
    {
        return [
            OrderStatusListLayout::class
        ];
    }
}

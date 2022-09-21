<?php

namespace App\Orchid\Screens;

use App\Models\Order;
use App\Orchid\Layouts\OrderListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class OrderListScreen extends Screen
{
    public $name = 'Статус заказа';

    public function query(): array
    {
        return [
            'orders' => Order::filters()->defaultSort('id')->paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.orders.edit')
        ];
    }

    public function layout(): array
    {
        return [
            OrderListLayout::class
        ];
    }
}

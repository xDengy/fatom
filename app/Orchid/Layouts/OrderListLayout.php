<?php

namespace App\Orchid\Layouts;

use App\Models\Order;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OrderListLayout extends Table
{
    protected $target = 'orders';
    protected function columns(): array
    {
        return [
            TD::make('id', 'Id')
                ->sort()
                ->filter(Input::make()),
            TD::make('name', 'Имя')->render(function (Order $order) {
                return Link::make($order->name)->route('platform.orders.editItem', $order);
            }),
            TD::make('tel', 'Телефон'),
            TD::make('status', 'Статус')
                ->filter(TD::FILTER_SELECT, Order::getStatusList())
                ->render(function (Order $order) {
                    return '<span class="">' . $order->status_name . '</span>';
                }),

            TD::make('created_at', 'Дата создания')->render(function (Order $order) {
                return $order->created_at->format('d.m.Y H:i');
            }),
        ];
    }
}

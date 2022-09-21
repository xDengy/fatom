<?php

namespace App\Orchid\Screens;

use App\Models\Product;
use App\Orchid\Layouts\ProductListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ProductListScreen extends Screen
{
    public $name = 'Товары';

    public function query(): array
    {
        return [
            'product' => Product::filters()->defaultSort('id')->paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.product.edit'),
            Link::make('Экспорт')
                ->icon('plus')
                ->route('platform.product.export'),
            Link::make('Импорт')
                ->icon('plus')
                ->route('platform.product.import')
        ];
    }

    public function layout(): array
    {
        return [
            ProductListLayout::class
        ];
    }
}
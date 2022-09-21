<?php

namespace App\Orchid\Layouts;

use App\Models\Category;
use App\Models\Product;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductListLayout extends Table
{
    protected $target = 'product';
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->sort()
                ->filter(Input::make()),
            TD::make('title', 'Название')->render(function (Product $product) {
                return Link::make($product->title)->route('platform.product.edit', $product);
            })
                ->sort()
                ->filter(Input::make()),
            TD::make('price_title', 'Цена')
                ->sort(),
            TD::make('category_id', 'Категория')->render(function (Product $product) {
                return Link::make(
                    Category::where('id', $product->category_id)->first()->title
                )->route(
                    'platform.category.edit',
                    Category::where('id', $product->category_id)->first()
                );
            })
                ->sort()
                ->filter(
                    Select::make()->empty('No select')->fromModel(
                        Category::where('has_products', '1'),
                        'title'
                    )
                )
        ];
    }
}

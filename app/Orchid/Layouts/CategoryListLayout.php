<?php

namespace App\Orchid\Layouts;

use App\Models\Category;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryListLayout extends Table
{
    protected $target = 'category';
    protected function columns(): array
    {
        return [
            TD::make('id', 'Id')
                ->sort()
                ->filter(Input::make()),
            TD::make('title', 'Название')->render(function (Category $category) {
                return Link::make($category->title)->route('platform.category.edit', $category);
            })
                ->sort()
                ->filter(Input::make()),
            TD::make('slug', 'Slug')->render(function (Category $category) {
                return Link::make($category->slug)->target('_blank')->route(
                    'catalog.category',
                    $category
                );
            }),
            TD::make('position', 'Позиция'),
            TD::make('has_products', 'Есть товары')
                ->sort()
                ->filter(Input::make())
        ];
    }
}

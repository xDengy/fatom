<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use App\Orchid\Layouts\CategoryListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class CategoryListScreen extends Screen
{
    public $name = 'Категории';

    public function query(): array
    {
        return [
            'category' => Category::filters()->defaultSort('id')->paginate(25)
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.category.edit')
        ];
    }

    public function layout(): array
    {
        return [
            CategoryListLayout::class
        ];
    }
}

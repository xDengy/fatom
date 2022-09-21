<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use App\Orchid\Layouts\OptionListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class OptionListScreen extends Screen
{
    public $category;

    public function query(Category $category): array
    {
        $this->category = $category;
        $this->name = 'Опции категории ' . $category->title;
        return [
            'options' => $category->options
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.options.add', $this->category),
            Button::make('Сохранить')
                ->icon('save')
                ->method('update'),
            Link::make('Назад')
                ->icon('arrow-left')
                ->route('platform.category.edit', $this->category),

        ];
    }

    public function layout(): array
    {
        return [
            OptionListLayout::class
        ];
    }

    public function update(Request $request, Category $category)
    {
        $optionsToUpd = $request->all('option');
        $optionsToUpd = $optionsToUpd['option'] ?? [];

        $options = $category->options()->pluck('id')->toArray();
        $category->options()->syncWithPivotValues($optionsToUpd, ['active' => 1], false);
        $category->options()->syncWithPivotValues(
            array_diff($options, $optionsToUpd),
            ['active' => 0],
            false
        );

        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.options.list', $category);
    }
}

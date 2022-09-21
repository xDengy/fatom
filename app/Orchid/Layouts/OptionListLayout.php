<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class OptionListLayout extends Table
{
    protected $target = 'options';

    protected function columns(): array
    {
        return [
            TD::make('title', 'Название')->render(function ($option) {
                return $option->title;
            }),
            TD::make('active', 'Показывать в фильтрах')->render(function ($option) {
                return CheckBox::make('option[]')->value($option->id)->checked(
                    boolval($option->pivot->active)
                );
            }),
        ];
    }
}

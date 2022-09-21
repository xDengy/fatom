<?php

namespace App\Orchid\Screens;

use App\Models\ProfitWorks;
use App\Orchid\Layouts\ProfitListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ProfitWorkListScreen extends Screen
{
    public $name = 'Выгодно работать';

    public function query(): array
    {
        return [
            'profit_works' => ProfitWorks::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.profit_work.edit')
        ];
    }

    public function layout(): array
    {
        return [
            ProfitListLayout::class
        ];
    }
}
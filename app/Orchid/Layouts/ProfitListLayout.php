<?php

namespace App\Orchid\Layouts;

use App\Models\ProfitWorks;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProfitListLayout extends Table
{
    protected $target = 'profit_works';
    protected function columns(): array
    {
        return [
            TD::make('title', 'Название')->render(function (ProfitWorks $seo){
                return Link::make($seo->title)->route('platform.profit_work.edit', $seo);
            }),
            TD::make('description', 'Описание')
        ];
    }
}
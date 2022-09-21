<?php

namespace App\Orchid\Layouts;

use App\Models\Deliveries;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DeliveriesListLayout extends Table
{
    protected $target = 'deliveries';
    protected function columns(): array
    {        
        return [
            TD::make('type', 'Тип')->render(function (Deliveries $seo) {
                return Link::make($seo->type)->route('platform.deliveries.editItem', $seo);
            }),
        ];
    }
}

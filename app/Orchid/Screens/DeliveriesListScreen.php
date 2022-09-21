<?php

namespace App\Orchid\Screens;

use App\Models\Deliveries;
use App\Orchid\Layouts\DeliveriesListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class DeliveriesListScreen extends Screen
{
    public $name = 'Доставка';

    public function query(): array
    {
        return [
            'deliveries' => Deliveries::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.deliveries.edit')
        ];
    }

    public function layout(): array
    {
        return [
            DeliveriesListLayout::class
        ];
    }
}

<?php

namespace App\Orchid\Screens;

use App\Models\Service;
use App\Orchid\Layouts\ServicesListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ServiceListScreen extends Screen
{
    public $name = 'Услуги';

    public function query(): array
    {
        return [
            'services' => Service::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.services.edit')
        ];
    }

    public function layout(): array
    {
        return [
            ServicesListLayout::class
        ];
    }
}

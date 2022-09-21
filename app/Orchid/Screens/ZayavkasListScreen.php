<?php

namespace App\Orchid\Screens;

use App\Models\Zayavka;
use App\Orchid\Layouts\ZayavkasListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ZayavkasListScreen extends Screen
{
    public $name = 'Заявки';

    public function query(): array
    {
        return [
            'zayavkas' => Zayavka::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
        ];
    }

    public function layout(): array
    {
        return [
            ZayavkasListLayout::class
        ];
    }
}

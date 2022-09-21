<?php

namespace App\Orchid\Screens;

use App\Models\Domains;
use App\Orchid\Layouts\DomainsListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class DomainsListScreen extends Screen
{
    public $name = 'Домены';

    public function query(): array
    {
        return [
            'domains' => Domains::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.domains.edit')
        ];
    }

    public function layout(): array
    {
        return [
            DomainsListLayout::class
        ];
    }
}

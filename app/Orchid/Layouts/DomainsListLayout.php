<?php

namespace App\Orchid\Layouts;

use App\Models\Domains;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DomainsListLayout extends Table
{
    protected $target = 'domains';
    protected function columns(): array
    {
        return [
            TD::make('domain_city', 'Город')->render(function (Domains $seo) {
                return Link::make($seo->domain_city)->route('platform.domains.editItem', $seo);
            }),
            TD::make('address', 'Адрес'),
            TD::make('tel', 'Телефон'),
        ];
    }
}

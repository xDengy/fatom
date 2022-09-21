<?php

namespace App\Orchid\Layouts;

use App\Models\Zayavka;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ZayavkasListLayout extends Table
{
    protected $target = 'zayavkas';
    protected function columns(): array
    {
        return [
            TD::make('domain', 'Домен')->render(function (Zayavka $seo) {
                return Link::make($seo->domain)->route('platform.zayavkas.editItem', $seo);
            }),
            TD::make('name', 'Имя'),
            TD::make('tel', 'Телефон'),
            TD::make('message', 'Сообщение'),
        ];
    }
}

<?php

namespace App\Orchid\Layouts;

use App\Models\Settings;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SettingsListLayout extends Table
{
    protected $target = 'settings';
    protected function columns(): array
    {
        return [
            TD::make('email', 'Почта')->render(function (Settings $seo){
                return Link::make($seo->email)->route('platform.settings.edit', $seo);
            }),
            TD::make('tel', 'Телефон')
        ];
    }
}
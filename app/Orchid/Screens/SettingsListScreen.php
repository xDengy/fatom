<?php

namespace App\Orchid\Screens;

use App\Models\Settings;
use App\Orchid\Layouts\SettingsListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class SettingsListScreen extends Screen
{
    public $name = 'Настройки';

    public function query(): array
    {
        return [
            'settings' => Settings::paginate()
        ];
    }

    public function commandBar(): array
    {
        $this->exists = Settings::first();
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.settings.edit')
                ->canSee(!$this->exists)
        ];
    }

    public function layout(): array
    {
        return [
            SettingsListLayout::class
        ];
    }
}

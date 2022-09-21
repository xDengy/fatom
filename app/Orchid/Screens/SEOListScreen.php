<?php

namespace App\Orchid\Screens;

use App\Models\SEO;
use App\Orchid\Layouts\SEOListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class SEOListScreen extends Screen
{
    public $name = 'SEO';
    public $description = 'CUP - Страницы и СЕО';

    public function query(): array
    {
        return [
            's_e_o_s' => SEO::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.seo.edit')
        ];
    }

    public function layout(): array
    {
        return [
            SEOListLayout::class
        ];
    }
}
<?php

namespace App\Orchid\Layouts;

use App\Models\Service;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServicesListLayout extends Table
{
    protected $target = 'services';
    protected function columns(): array
    {
        return [
            TD::make('title', 'Название')->render(function (Service $seo) {
                return Link::make($seo->title)->route('platform.services.edit', $seo);
            }),
            TD::make('description', 'Описание'),
            TD::make('SEO_text', 'SEO текст')
        ];
    }
}

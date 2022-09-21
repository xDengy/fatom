<?php

namespace App\Orchid\Layouts;

use App\Models\SEO;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SEOListLayout extends Table
{
    protected $target = 's_e_o_s';
    protected function columns(): array
    {
        return [
            TD::make('page', 'Страница')->render(function (SEO $seo){
                return Link::make($seo->page)->route('platform.seo.edit', $seo);
            }),
            TD::make('page_url', 'URL'),
            TD::make('h1', 'H1'),
            TD::make('title', 'Заголовок - Title'),
            TD::make('description', 'Описание - Description')
        ];
    }
}
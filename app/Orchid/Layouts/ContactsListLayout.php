<?php

namespace App\Orchid\Layouts;

use App\Models\Contact;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ContactsListLayout extends Table
{
    protected $target = 'contacts';
    protected function columns(): array
    {
        return [
            TD::make('city', 'Город')->render(function (Contact $seo) {
                return Link::make($seo->city)->route('platform.contacts.editItem', $seo);
            }),
            TD::make('address', 'Адрес'),
            TD::make('tel', 'Телефон'),
        ];
    }
}

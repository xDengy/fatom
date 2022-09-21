<?php

namespace App\Orchid\Screens;

use App\Models\Contact;
use App\Orchid\Layouts\ContactsListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class ContactsListScreen extends Screen
{
    public $name = 'Контакты';

    public function query(): array
    {
        return [
            'contacts' => Contact::paginate()
        ];
    }

    public function commandBar(): array
    {
        return [
            Link::make('Добавить')
                ->icon('plus')
                ->route('platform.contacts.edit')
        ];
    }

    public function layout(): array
    {
        return [
            ContactsListLayout::class
        ];
    }
}

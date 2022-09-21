<?php

namespace App\Orchid\Screens;

use App\Models\Contact;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ContactsEditScreen extends Screen
{

    public $name = 'Контакты';
    public $exists = false;

    public function query(Contact $contact): array
    {
        $this->exists = $contact->exists;
        if ($this->exists) {
            $this->name = 'Редактировать страницу: ' . $contact->city;
        } else {
            $this->name = 'Создать страницу';
        }
        $contact->load('mainImg');
        return [
            'contacts' => $contact
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Создать')
                ->icon('save-alt')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Сохранить')
                ->icon('save')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),

            Link::make('Назад')
                ->icon('arrow-left')
                ->route('platform.contacts.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('contacts.city')
                        ->title('Город')
                        ->required(),
                    Input::make('contacts.address')
                        ->title('Адрес')
                        ->required(),
                    Input::make('contacts.tel')
                        ->title('Телефон')
                        ->required(),
                    Input::make('contacts.geo')
                        ->title('Геолокация')
                        ->required()
                ])
            ])->title('Информация'),
            Layout::rows([
                Picture::make('contacts.image_path')
                  ->title('Изображения')
                  ->required(),
            ])->title('ФОТО и Изображения'),
        ];
    }

    public function createOrUpdate(Contact $seo, Request $request)
    {
        $fill = [];
        foreach ($request->get('contacts') as $key => $value) {
            if($key == 'image_path' && $value !== null) {
                $fill[$key] = str_replace(url('/'), '', $value);
            } else {
                $fill[$key] = $value;
            }
        }
        $seo->fill($fill)->save();
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.contacts.list');
    }

    public function remove(Contact $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.contacts.list');
    }
}

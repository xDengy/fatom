<?php

namespace App\Orchid\Screens;

use App\Models\Domains;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DomainsEditScreen extends Screen
{

    public $name = 'Контакты';
    public $exists = false;

    public function query(Domains $domains): array
    {
        $this->exists = $domains->exists;
        if ($this->exists) {
            $this->name = 'Редактировать страницу: ' . $domains->city;
        } else {
            $this->name = 'Создать страницу';
        }
        return [
            'domains' => $domains
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
                ->route('platform.domains.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('domains.domain')
                        ->title('Имя домена')
                        ->required(),
                    Input::make('domains.domain_city')
                        ->title('Город домена')
                        ->help('Именительный падеж')
                        ->required(),
                    Input::make('domains.domain_city_text')
                        ->title('Город домена')
                        ->help('Предложный падеж')
                        ->required()
                ])
            ]),
            Layout::rows([
                Group::make([
                    Input::make('domains.tel')
                        ->title('Телефон 1')
                        ->required(),
                    Input::make('domains.tel2')
                        ->title('Телефон 2')
                        ->required(),
                    Input::make('domains.address')
                        ->title('Адрес')
                        ->required()
                ])
            ]),
        ];
    }

    public function createOrUpdate(Domains $seo, Request $request)
    {
        $fill = [];
        foreach ($request->get('domains') as $key => $value) {
            $fill[$key] = $value;
        }
        $seo->fill($fill)->save();
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.domains.list');
    }

    public function remove(Domains $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.domains.list');
    }
}

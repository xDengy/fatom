<?php

namespace App\Orchid\Screens;

use App\Models\Zayavka;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ZayavkasEditScreen extends Screen
{

    public $name = 'Заявки';
    public $exists = false;
    public $file = false;

    public function query(Zayavka $zayavka): array
    {
        $this->exists = $zayavka->exists;
        if ($this->exists) {
            $this->name = 'Заявка №' . $zayavka->id;
            $this->file = $zayavka->file ? $zayavka->file : false;
        } else {
            $this->name = 'Создать страницу';
        }
        return [
            'zayavkas' => $zayavka
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists),

            Link::make('Назад')
                ->icon('arrow-left')
                ->route('platform.zayavkas.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('zayavkas.domain')
                        ->title('Домен')
                        ->readOnly(),
                    Input::make('zayavkas.name')
                        ->title('Имя')
                        ->readOnly(),
                    Input::make('zayavkas.tel')
                        ->title('Телефон')
                        ->readOnly(),
                ]),
            ]),
            Layout::rows([
                TextArea::make('zayavkas.message')
                    ->title('Сообщение')
                    ->rows(30)
                    ->readOnly(),
                Link::make('Файл')
                    ->canSee($this->file)
                    ->href($this->file)
            ]),
        ];
    }

    public function remove(Zayavka $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.zayavkas.list');
    }
}

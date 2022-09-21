<?php

namespace App\Orchid\Screens;

use App\Models\Deliveries;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class DeliveriesEditScreen extends Screen
{

    public $name = 'Доставка';
    public $exists = false;

    public function query(Deliveries $delivery): array
    {
        $this->exists = $delivery->exists;
        if ($this->exists) {
            $this->name = 'Редактировать страницу: ' . $delivery->type;
        } else {
            $this->name = 'Создать страницу';
        }
        return [
            'deliveries' => $delivery
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
                ->route('platform.deliveries.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('deliveries.type')
                        ->title('Тип')
                        ->required(),
                    Input::make('deliveries.value')
                        ->title('Значение')
                        ->required(),
                ])
            ]),
        ];
    }

    public function createOrUpdate(Deliveries $seo, Request $request)
    {
        $fill = [];
        foreach ($request->get('deliveries') as $key => $value) {
            $fill[$key] = $value;
        }
        $seo->fill($fill)->save();
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.deliveries.list');
    }

    public function remove(Deliveries $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.deliveries.list');
    }
}

<?php

namespace App\Orchid\Screens;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class OrderStatusEditScreen extends Screen
{

    public $name = 'Статусы заказа';
    public $exists = false;

    public function query(OrderStatus $delivery): array
    {
        $this->exists = $delivery->exists;
        if ($this->exists) {
            $this->name = 'Редактировать страницу: ' . $delivery->type;
        } else {
            $this->name = 'Создать страницу';
        }
        return [
            'order_status' => $delivery
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
                ->route('platform.order_status.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('order_status.status')
                        ->title('Статус')
                        ->required(),
                    Input::make('order_status.value')
                        ->title('Значение')
                        ->required(),
                ])
            ]),
        ];
    }

    public function createOrUpdate(OrderStatus $seo, Request $request)
    {
        $fill = [];
        foreach ($request->get('order_status') as $key => $value) {
            $fill[$key] = $value;
        }
        $seo->fill($fill)->save();
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.order_status.list');
    }

    public function remove(OrderStatus $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.order_status.list');
    }
}

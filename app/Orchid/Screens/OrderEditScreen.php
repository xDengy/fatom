<?php

namespace App\Orchid\Screens;

use App\Models\Deliveries;
use App\Models\Order;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class OrderEditScreen extends Screen
{

    public $name = 'Статусы заказа';
    public $exists = false;
    public $order;

    public function query(Order $order): array
    {
        $this->exists = $order->exists;
        $this->order = $order;
        if ($this->exists) {
            $this->name = 'Редактировать заказ: #' . $order->id;
        } else {
            $this->name = 'Создать заказ';
        }
        return [
            'order' => $order
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
                ->route('platform.orders.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('order.name')
                        ->title('Статус')
                        ->required(),
                    Input::make('order.tel')
                        ->title('Значение')
                        ->required(),
                    Input::make('order.email')
                        ->title('Значение')
                        ->required(),
                ])
            ]),
            Layout::rows([
                Group::make([
                    TextArea::make('order.message')
                        ->title('Сообщение')
                        ->rows(5)
                        ->required(),

                ]),
            ]),
            Layout::view('static.order.products', ['order' => $this->order]),
            Layout::rows([
                Group::make([
                    Select::make('order.status')
                        ->options(Order::getStatusList())
                        ->title('Статус')
                        ->required(),
                    Select::make('order.delivery_id')
                        ->fromModel(Deliveries::class, 'type')
                        ->title('Тип доставки')
                        ->required(),
                ])
            ]),
        ];
    }

    public function createOrUpdate(Order $seo, Request $request)
    {
        $fill = [];
        foreach ($request->get('order') as $key => $value) {
            if ($key == 'product_id') {
                $fill[$key] = implode(';', $value);
            } else {
                $fill[$key] = $value;
            }
        }
        $seo->fill($fill)->save();
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.orders.list');
    }

    public function remove(Order $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.orders.list');
    }
}

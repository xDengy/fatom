<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ProductEditScreen extends Screen
{

    public $exists = false;

    public function query(Product $seo): array
    {
        $this->exists = $seo->exists;
        if($this->exists){
            $this->name = 'Редактировать страницу: ' . $seo->title;
        } else {
            $this->name = 'Создать страницу';
        }
        $seo->load('mainImg');
        return [
            'product' => $seo
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
                ->route('platform.product.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('product.seo_title')
                        ->title('SEO название')
                        ->placeholder('Купить Долото алмазное М для мягких пород 220.7 мм ГОСТ 26474-85 в [[!+cf.name_rp]] ⭐ — ООО ФАТОМ')
                        ->required(),
                    Input::make('product.seo_description')
                        ->title('SEO описание')
                        ->placeholder(
                            'Купить Долото алмазное М для мягких пород 220.7 мм ГОСТ 26474-85 в [[!+cf.name_rp]] по выгодной цене. ООО ФАТОМ - широкий сортамент металлопродукции от поставщика.  Доставка, самовывоз с металлобазы. Склад в городе [[!+cf.name_ip]], скидка на доставку 15%. ☎ Звоните: [[!+cf.phone_1]] !'
                        )
                        ->required(),
                    Input::make('product.keywords')
                        ->title('SEO ключевые слова')
                        ->placeholder(
                            ', долото алмазное м для мягких пород 220.7 мм гост 26474-85 в [[!+cf.name_rp]], долото алмазное м для мягких пород 220.7 мм гост 26474-85 купить, долото алмазное м для мягких пород 220.7 мм гост 26474-85 цена, долото алмазное м для мягких пород 220.7 мм гост 26474-85 со склада, долото алмазное м для мягких пород 220.7 мм гост 26474-85 от производителя, долото алмазное м для мягких пород 220.7 мм гост 26474-85'
                        )
                        ->required(),
                    Input::make('product.title')
                        ->title('Название')
                        ->placeholder(
                            'Долото алмазное М для мягких пород 220.7 мм ГОСТ 26474-85 в [[!+cf.name_rp]]'
                        )
                        ->required(),
                ])
            ])->title('SEO'),
            Layout::rows([
                Group::make([
                    Input::make('product.price_title')
                        ->title('Цена')
                        ->placeholder('Договорная/Заказная/9999')
                        ->required(),
                    Select::make('product.category_id')
                        ->title('Родительская категория')
                        ->fromModel(Category::where('has_products', '1'), 'title')
                        ->required(),
                    Input::make('product.description')
                        ->title('Описание товара')
                        ->placeholder('Lorem'),
                ])
            ])->title('Опции'),
            Layout::rows([
                TextArea::make('product.options_translited')
                    ->title('Опции товара')
                    ->rows(10)
                    ->placeholder('Тип=М;Нтд=ГОСТ 26474-85;Материал=алмазное;Артикул=1201000222;')
                    ->required()
            ]),
            Layout::rows([
                Input::make('product.image_alt')
                    ->title('Альтернативное название изображения'),
                Input::make('product.image_title')
                    ->title('Название изображения'),
                // Picture::make('product.image_path')
                //     ->title('Изображения'),
                Input::make('product.image_path')
                    ->title('Изображение'),
            ])->title('Изображение'),
        ];
    }

    public function createOrUpdate(Product $seo, Request $request)
    {
        $fill = [];
        foreach ($request->get('product') as $key => $value) {
            if($key == 'image_path') {
                $fill[$key] = str_replace(url('/'), '', $value);
            } else {
                $fill[$key] = $value;
            }
        }
        $fill['image_alt'] = $fill['title'];
        $fill['image_title'] = $fill['title'];
        if($fill['price_title'] !== 'Договорная' && $fill['price_title'] !== 'Заказная') {
            $price = str_replace('От ', '', $fill['price_title']);
            $price = str_replace(' руб.', '', $price);
            $fill['price'] = $price;
        } else {
            $fill['price'] = 0;
        }

        $opts = explode(';', $fill['options_translited']);
        $engOpt = [];
        foreach ($opts as $key => $opt) {
            if($opt !== '' && $opt) {
                $splitedOpt = explode('=', $opt);
                $engOpt[$key] = Str::slug(mb_strtolower($splitedOpt[0])) . '=' . $splitedOpt[1];
            }
        }
        $fill['slug'] = Str::slug($fill['title']);
        $fill['options'] = implode(';', $engOpt);
        $seo->fill($fill)->save();
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.product.list');
    }

    public function remove(Product $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.product.list');
    }
}

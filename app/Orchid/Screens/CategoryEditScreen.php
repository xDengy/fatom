<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CategoryEditScreen extends Screen
{

    public $name = 'Категория';
    public $exists = false;
    public $category;

    public function query(Category $category): array
    {
        $this->exists = $category->exists;
        $this->category = $category;
        if ($this->exists) {
            $this->name = 'Редактировать категорию: ' . $category->title;
        } else {
            $this->name = 'Создать страницу';
        }
        $category->load('mainImg');
        return [
            'category' => $category
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
                ->route('platform.category.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::accordion([
                'Seo' => [
                    Layout::rows([
                        Group::make([
                            Input::make('category.seo_title')
                                ->title('SEO title')
                                ->placeholder('title'),
                            Input::make('category.seo_h1')
                                ->title('SEO H1')
                                ->placeholder('H1'),
                            Input::make('category.keywords')
                                ->title('Ключевыйе слова')
                                ->placeholder('купить листовой металл, нержавеющая сталь'),
                            Input::make('category.position')->type('number')->title('Позиция')->min(
                                1
                            )

                        ]),
                    ]),
                    Layout::rows([
                        Group::make([
                            TextArea::make('category.seo_description')
                                ->title('SEO описание'),
                            TextArea::make('category.description')
                                ->title('Описание'),
                        ]),
                    ])
                ]
            ]),
            Layout::rows([
                Group::make([
                    Input::make('category.title')
                        ->title('Название')
                        ->placeholder(
                            'Долото алмазное М для мягких пород 220.7 мм ГОСТ 26474-85 в [[!+cf.name_rp]]'
                        )
                        ->required(),
                    Input::make('category.slug')
                        ->title('Код категории')
                        ->placeholder(
                            'list-stalnoy'
                        )
                        ->required(),
                    Select::make('category.parent_id')
                        ->title('Родительская категория')
                        ->empty('Не выбрано')
                        ->fromModel(Category::class, 'title'),
                    CheckBox::make('category.has_products')
                        ->title('Есть товары'),
                ]),
                Group::make([
                    Select::make('category.options')
                        ->fromModel(Option::class, 'title')
                        ->multiple()
                        ->title('Опции'),
                    Link::make('Редактировать опции')
                        ->route('platform.options.list', $this->category)
                ]),

            ])->title('Категория'),
            Layout::rows([
                Picture::make('category.image_path')
                    ->title('Изображения')
                    ->required(),
            ])->title('ФОТО и Изображения'),
        ];
    }

    public function createOrUpdate(Category $category, Request $request)
    {
        $fill = [];
        foreach ($request->get('category') as $key => $value) {
            if ($key == 'image_path' && $value !== null) {
                $fill[$key] = str_replace(url('/'), '', $value);
            } else {
                $fill[$key] = $value;
            }
        }
        if (array_key_exists('has_products', $fill)) {
            $fill['has_products'] = '1';
        } else {
            $fill['has_products'] = null;
        }
        if (array_key_exists('parent_id', $fill)) {
            $fill['parent_id'] = $fill['parent_id'];
        } else {
            $fill['parent_id'] = null;
        }
        $fill['image_alt'] = $fill['title'];
        $fill['image_title'] = $fill['title'];
        $fill['slug'] = Str::slug($fill['title']);
        $category->fill($fill)->save();
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.category.list');
    }

    public function remove(Category $category)
    {
        // Product::where('category_id', $seo->id)->delete();
        // Category::where('parent_id', $seo->id)->delete();
        $category->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.category.list');
    }
}

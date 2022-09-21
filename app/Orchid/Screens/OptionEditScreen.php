<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use App\Models\CategoryOption;
use App\Models\Option;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class OptionEditScreen extends Screen
{

    public $exists = false;
    public Category $category;

    public function query(Category $category): array
    {
        $this->exists = $category->exists;
        $this->category = $category;
        if ($this->exists) {
            $this->name = 'Редактировать страницу';
        } else {
            $this->name = 'Создать страницу';
        }
        if ($category->active == 0) {
            $category->active = 'off';
        } else {
            $category->active = 'on';
        }
        return [
            'option' => $category
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
                ->route('platform.options.list', $this->category)
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Label::make('category.title')->value($this->category->title),
                Select::make('option_id')
                    ->fromModel(Option::class, 'title')
                    ->empty('Select value')
                    ->title('Опция')
                    ->required(),
                CheckBox::make('active')
                    ->value(1)
                    ->title('Активность'),
            ]),
        ];
    }

    public function createOrUpdate(Category $category, Request $request)
    {
        $category->options()->attach(
            $request->get('option_id'),
            ['active' => $request->get('active')]
        );
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.options.list', $category);
    }

    public function remove(CategoryOption $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.options.list', $this->category);
    }
}

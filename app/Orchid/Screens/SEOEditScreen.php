<?php

namespace App\Orchid\Screens;

use App\Models\SEO;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SEOEditScreen extends Screen
{

    public $name = 'SEO';
    public $description = 'CUP - Страницы и СЕО';
    public $exists = false;

    public function query(SEO $seo): array
    {
        $this->exists = $seo->exists;
        if($this->exists){
            $this->name = 'Редактировать страницу: ' . $seo->page;
        } else {
            $this->name = 'Создать страницу';
        }
        $seo->load('mainImg');
        return [
            'seo' => $seo
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
                ->route('platform.seo.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('seo.page')
                        ->title('Page')
                        ->placeholder('Page in controller')
                        ->required(),
                    Input::make('seo.page_url')
                        ->title('Page URL')
                        ->placeholder('Page URL in Router')
                        ->required(),
                    Input::make('seo.h1')
                        ->title('Заголовок H1')
                        ->placeholder()
                        ->required(),
                    Input::make('seo.title')
                        ->title('Title')
                        ->placeholder('Meta Title')
                        ->required(),
                ]),
                Group::make([
                    TextArea::make('seo.description')
                        ->title('Description')
                        ->rows(3),
                    TextArea::make('seo.keywords')
                        ->rows(3)
                        ->title('Ключевые слова'),
                ]),

            ])->title('SEO'),
            Layout::rows([
                TextArea::make('seo.subtitle')
                    ->rows(10)
                    ->title('Подзаголовок'),
                Quill::make('seo.fulldesc')
                    ->title('Подробное описание'),
            ])->title('Описания'),
            Layout::rows([
                Group::make([
                    Input::make('seo.phone')
                        ->title('Телефон'),
                    Input::make('seo.email')
                        ->title('Почта'),
                ]),
                Group::make([
                    Input::make('seo.city')
                        ->title('Город'),
                    Input::make('seo.street')
                        ->title('Улица'),
                ]),
                Group::make([
                    Input::make('seo.weekdays')
                        ->title('Будни'),
                    Input::make('seo.weekend')
                        ->title('Выходные'),
                ]),
                Group::make([
                    Input::make('seo.link1')
                        ->title('Ссылка 1'),
                    Input::make('seo.link2')
                        ->title('Ссылка 2'),
                    Input::make('seo.link3')
                        ->title('Ссылка 3'),
                ]),
            ])->title('Контакты'),
            Layout::rows([
                Input::make('seo.doptitle1')
                    ->title('Заголовок 1'),
                Quill::make('seo.doptxt1')
                    ->title('Доп. описание 1'),

                Input::make('seo.doptitle2')
                    ->title('Заголовок 2'),
                Quill::make('seo.doptxt2')
                    ->title('Доп. описание 2'),

                Input::make('seo.doptxt3')
                    ->title('Доп. описание 3'),
            ])->title('Дополнительно'),
            Layout::rows([
                Group::make([
                    Code::make('seo.codkarti')
                      ->language(Code::MARKUP)
                      ->title('КОД 1'),
                    Code::make('seo.codhtml')
                      ->language(Code::MARKUP)
                      ->title('КОД 2'),
                ]),
            ])->title('Разное'),
            Layout::rows([
                Picture::make('seo.hero')
                    ->title('Изображения'),
            ])->title('ФОТО и Изображения'),
        ];
    }

    public function createOrUpdate(SEO $seo, Request $request)
    {
        $fill = [];
        foreach ($request->get('seo') as $key => $value) {
            if($key == 'hero' && $value !== null) {
                $fill[$key] = str_replace(url('/'), '', $value);
            } else {
                $fill[$key] = $value;
            }
        }
        $seo->fill($fill)->save();

        Alert::info('You have successfully created / updated.');
        return redirect()->route('platform.seo.list');
    }

    public function remove(SEO $seo)
    {
        $seo->delete();
        Alert::info('You have successfully deleted.');
        return redirect()->route('platform.seo.list');
    }
}

<?php

namespace App\Orchid\Screens;

use App\Models\Service;
use App\Services\Transliterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ServicesEditScreen extends Screen
{
    public $exists = false;

    public function query(Service $seo): array
    {
        $this->exists = $seo->exists;
        if($this->exists){
            $this->name = 'Редактировать страницу: ' . $seo->title;
        } else {
            $this->name = 'Создать страницу';
        }
        $seo->load('attachment');
        return [
            'service' => $seo
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
                ->route('platform.services.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Input::make('service.title')
                    ->title('Название')
                    ->placeholder('title in controller')
                    ->required(),
                TextArea::make('service.preview_text')
                    ->title('Описание анонса')
                    ->placeholder('description in Router')
                    ->rows(20)
                    ->required(),
                TextArea::make('service.description')
                    ->title('Описание')
                    ->placeholder('description in Router')
                    ->rows(20)
                    ->required(),
                TextArea::make('service.SEO_text')
                    ->title('HTML описание')
                    ->placeholder()
                    ->rows(20)
                    ->required()
            ])->title('Сервис'),
            Layout::rows([
                Upload::make('service.attachment')
                    ->title('Изображения')
                    ->groups('photos'),
            ])->title('ФОТО и Изображения'),
        ];
    }

    public function createOrUpdate(Service $seo, Request $request)
    {
        $fill = [];
        foreach ($request->get('service') as $key => $value) {
            $fill[$key] = $value;
        }
        $fill['slug'] = Str::slug($fill['title']);

        $seo->fill($fill)->save();

        $seo->attachment()->syncWithoutDetaching(
            $request->input('service.attachment', [])
        );
        
        Alert::info('You have successfully created / updated.');
        return redirect()->route('platform.services.list');
    }

    public function remove(Service $seo, Request $request)
    {
        $seo->attachment()->first()->delete();
        $seo->delete();
        Alert::info('You have successfully deleted.');
        return redirect()->route('platform.services.list');
    }
}

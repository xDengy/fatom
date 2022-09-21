<?php

namespace App\Orchid\Screens;

use App\Models\ProfitWorks;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Code;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\DB;
use App\Services\Transliterator;

class ProfitEditScreen extends Screen
{
    public $exists = false;

    public function query(ProfitWorks $seo): array
    {
        $this->exists = $seo->exists;
        if($this->exists){
            $this->name = 'Редактировать страницу: ' . $seo->title;
        } else {
            $this->name = 'Создать страницу';
        }
        return [
            'profit_works' => $seo
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
                ->route('platform.profit_work.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('profit_works.title')
                        ->title('Название')
                        ->placeholder('title in controller')
                        ->required(),
                    Input::make('profit_works.description')
                        ->title('Описание')
                        ->placeholder('description in Router')
                        ->required(),
                ])                
            ]),            
        ];
    }

    public function createOrUpdate(ProfitWorks $seo, Request $request)
    {
        $seo->fill($request->get('profit_works'))->save();    
        Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.profit_work.list');
    }

    public function remove(ProfitWorks $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.profit_work.list');
    }
}
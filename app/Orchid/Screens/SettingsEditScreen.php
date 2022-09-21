<?php

namespace App\Orchid\Screens;

use App\Models\Settings;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class SettingsEditScreen extends Screen
{

    public $exists = false;

    public function query(Settings $seo): array
    {
        $this->exists = $seo->exists;
        if($this->exists){
            $this->name = 'Редактировать страницу ';
        }
        $seo->load('mainImg');
        return [
            'settings' => $seo
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
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Group::make([
                    Input::make('settings.email')
                        ->title('Электронная почта')
                        ->required(),
                    Input::make('settings.tel')
                        ->title('Телефон')
                        ->required(),
                ])
            ])
        ];
    }

    public function createOrUpdate(Settings $seo, Request $request)
    {
        $seo->fill($request->get('settings'))->save();
        Alert::info('You have successfully created / updated.');
        return redirect()->route('platform.settings.list');
    }

    public function remove(Settings $seo)
    {
        $seo->delete();
        Alert::info('You have successfully deleted.');
        return redirect()->route('platform.settings.list');
    }
}

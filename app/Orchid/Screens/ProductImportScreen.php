<?php

namespace App\Orchid\Screens;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Fields\Picture;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Response;
use Illuminate\Http\Testing\MimeType;
use App\Helpers\DataImport;
use File;

class ProductImportScreen extends Screen
{

    public $exists = false;

    public function query(Product $seo): array
    {
        $this->exists = $seo->exists;
        $this->name = 'Импортировать товары';
        $seo->load('mainImg');
        return [
            'product' => $seo
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Импортировать')
                ->icon('save-alt')
                ->method('import'),

            Link::make('Назад')
                ->icon('arrow-left')
                ->route('platform.product.list')
        ];
    }

    public function layout(): array
    {
        return [
            Layout::rows([
                Upload::make('product.filename')
                    ->required(),
            ])
        ];
    }

    public function import(Product $seo, Request $request)
    {
        ini_set('memory_limit', '256M');
        $requestData = $request->get('product');
        $attachment = DB::table('attachments')->where('id', $requestData['filename'][0])->first();
        $fullPath = 'storage/' . $attachment->path . $attachment->name . '.' . $attachment->extension;
        $data = DataImport::parse($fullPath);
        $firstData = $data;
        $headers = $data['headers'] ?? [];
        $data = $data['data'] ?? [];
        if (!empty($data)) {
            $structure = DataImport::buildItems($data, $headers);
        } else {
            Alert::info('Ошибка в файле');
            return;
        }
        foreach ($structure['data'] as $strKey => $strVal) {
            DB::table('products')->updateOrInsert($strVal);
        }
        foreach ($structure['options'] as $optKey => $optVal) {
            DB::table('options')->updateOrInsert($optVal);
        }
        DB::table('attachments')->where('id', $attachment->id)->delete();
        File::delete($fullPath);
        Alert::info('Успешно создано/изменено');        
    }

    public function remove(Product $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.product.list');
    }
}

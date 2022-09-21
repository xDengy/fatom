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
use Response;
use Illuminate\Http\Testing\MimeType;
use File;

class ProductExportScreen extends Screen
{

    public $exists = false;

    public function query(Product $seo): array
    {
        $this->exists = $seo->exists;
        $this->name = 'Экспортировать товары';
        $seo->load('mainImg');
        return [
            'product' => $seo
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make('Экспортировать')
                ->icon('save-alt')
                ->method('export'),

            Link::make('Назад')
                ->icon('arrow-left')
                ->route('platform.product.list'),
        ];
    }

    public function layout(): array
    {
        if(array_key_exists('link', $_GET)) {
            $rows = [
                Layout::rows([
                    Link::make('Скачать')
                        ->href($_GET['link']),
                    Link::make('Экспортировать')
                        ->route('platform.product.export')
                ])
            ];
        } else {
            $rows = [
                Layout::rows([
                    Select::make('product.category_id')
                        ->title('Родительская категория')
                        ->fromModel(Category::where('has_products', '1'), 'title')
                        ->required(),
                ])
            ];
        }

        return $rows;
    }

    public function export(Product $seo, Request $request)
    {
        ini_set('memory_limit', '256M');
        $requestData = $request->get('product');
        $products = $seo->where('category_id', $requestData['category_id'])->get()->toArray();
        $exportData = [];
        $exportDataHeaders = [];
        $headers = [];
        $exportStr = [];
        foreach ($products as $key => $product) {
            foreach($product as $productKey => $productValue) {
                if($productKey !== 'options_translited' && 
                    $productKey !== 'created_at' && 
                    $productKey !== 'updated_at') {
                        if($productKey !== 'category_id' && $productKey !== 'options') {
                                $headers[$productKey] = $productKey;
                        } else if($productKey == 'category_id') {
                            $headers[$productKey] = $productKey;
                        } else if($productKey == 'options') {
                            $options = explode(';', $productValue);
                            foreach ($options as $optionKey => $option) {
                                [$optionTitle, $optionValue] = explode('=', $option);
                                $headers[$optionTitle] = $optionTitle;
                            }
                        }

                }
            }
        }
        foreach ($products as $key => $product) {
            $options = explode(';', $product['options']);
            foreach ($options as $optionKey => $option) {
                [$optionTitle, $optionValue] = explode('=', $option);
                $product[$optionTitle] = $optionValue;
            }
            $product['category_id'] = Category::where('id', $product['category_id'])->where('has_products', '1')->first()->title;
            foreach($headers as $headerKey => $headerValue) {
                if(!array_key_exists($headerKey, $product)) {
                    $exportData[$key][$headerKey] = '';
                } else {
                    $exportData[$key][$headerKey] = $product[$headerKey];
                }
            }
            //$exportStr[] = implode(';', $exportData[$key]);
        }

        if (!File::exists(public_path()."/files")) {
            File::makeDirectory(public_path() . "/files");
        }
        //dd($exportData);
        $filename =  public_path("/files/download.csv");
        $handle = fopen($filename, 'w');
        fputcsv($handle, $headers, ';');
        foreach ($exportData as $exportDataKey => $exportDataValue) {
            fputcsv($handle, $exportDataValue);
        }
        fclose($handle);

        $headersDownload = array(
            'Content-Type: text/csv',
          );
        //return response()->download(public_path(). '/files/download.csv', 'download2.csv', $headersDownload);
        Alert::info('Успешно');
        //Alert::info('Успешно создано/изменено');
        return redirect()->route('platform.product.export', [
            'link' => '/files/download.csv'
        ]);
    }

    public function remove(Product $seo)
    {
        $seo->delete();
        Alert::info('Успешно удалено');
        return redirect()->route('platform.product.list');
    }
}

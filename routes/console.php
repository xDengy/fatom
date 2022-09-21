<?php

use App\Helpers\DataImport;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('xlsx-items', function () {
    ini_set('max_execution_time', 10000);
    $import_dir = 'resources/data/import';
    $importFiles = scandir(realpath($import_dir));
    $structure = [];
    $i = 1;
    $count = count($importFiles) - 2;
    foreach ($importFiles as $importFile) {
        if ($importFile == '.' || $importFile == '..') {
            continue;
        }
        print_r("processing $i of $count file: $importFile\n");
        $i++;
        $importFile = $import_dir . '/' . $importFile;

        $data = DataImport::parse($importFile);
        $headers = $data['headers'] ?? [];
        $data = $data['data'] ?? [];

        if (empty($data)) {
            print_r("empty data from file: $importFile\n");
            continue;
        }
        $structure = DataImport::buildItems($data, $headers);
        if ($structure) {
            foreach ($structure['data'] as $datum) {
                DB::table('products')->updateOrInsert($datum);
            }

            foreach ($structure['options'] as $datum) {
                DB::table('options')->updateOrInsert($datum);
            }
        }
    }

    dd('import finished');

    $filename = realpath(
        'resources/data/products/01.xlsx'
    );
    //foreach (glob($sourceDirectory . "/*.xlsx") as $filename) {
    $data = DataImport::parse($filename);
    $headers = $data['headers'] ?? [];
    $data = $data['data'] ?? [];
    if (!empty($data)) {
        $structure = DataImport::buildItems($data, $headers);
    }

    foreach ($structure['data'] as $strKey => $strVal) {
        $prod = DB::table('products')->where($strVal)->first();
            if(!$prod) {
                DB::table('products')->updateOrInsert($strVal);
            }
    }
    foreach ($structure['options'] as $optKey => $optVal) {
        $opt = DB::table('options')->where('slug', $optVal['slug'])->first();
        if (!$prod) {
            DB::table('options')->updateOrInsert($optVal);
        }
    }
    //}
    die;
});

Artisan::command('category:link-option', function () {
    $products = DB::table('products')->select(['options', 'category_id'])->orderBy(
        'category_id'
    )->get();
    $temp = DB::table('options')->select(['id', 'title'])->get();
    $existingOptions = array_combine(
        $temp->pluck('id')->toArray(),
        $temp->pluck('title')->toArray()
    );
    $toDb = [];
    foreach ($products as $product) {
        $cat_id = $product->category_id;
        $options = explode(';', $product->options);
        $options = array_map(function ($item) {
            return explode('=', $item)[0];
        }, $options);
        if (array_key_exists($cat_id, $toDb)) {
            $toDb[$cat_id] = $toDb[$cat_id] + $options;
        } else {
            $toDb[$cat_id] = $options;
        }
        $toDb[$cat_id] = array_unique($toDb[$cat_id]);
        $toDb[$cat_id] = array_flip(array_intersect($existingOptions, $toDb[$cat_id]));
    }
    $sql = [];
    foreach ($toDb as $cat_id => $options) {
        foreach ($options as $option_id) {
            $sql[] = "INSERT IGNORE INTO `category_options` (`category_id`, `option_id`) VALUES ($cat_id, $option_id);";
        }
    }
    $sql = implode("\n", $sql);

    DB::unprepared($sql);
    dd('Done');
});

Artisan::command('product-desc', function () {
    $products = DB::table('products')->select(['options', 'options_translited', 'id'])->where(
        'options',
        'like',
        "%описание%"
    )->get();
    $productsTr = array_combine(
        $products->pluck('id')->toArray(),
        $products->pluck('options_translited')->toArray()
    );
    $products = array_combine(
        $products->pluck('id')->toArray(),
        $products->pluck('options')->toArray()
    );
    $desc = [];
    $newOptions = [];
    $newOptionsTr = [];
    foreach ($products as $id => $optionsStr) {
        $options = explode(';', $optionsStr);
        $optionsTr = explode(';', $productsTr[$id]); //opisanie
        foreach ($options as $i => $option) {
            if (Str::contains($option, 'описание')) {
                [$title, $description] = explode('=', $option);
                $desc[$id] = $description;
                continue;
            }
            $newOptions[$id][] = $option;
            $newOptionsTr[$id][] = $optionsTr[$i];
        }
    }
    $sql = [];
    foreach ($desc as $id => $description) {
        $options = implode(';', $newOptions[$id]);
        $optionsTr = implode(';', $newOptionsTr[$id]);
        $sql[] = "update `products` set `description`='" . $description . "',`options`='$options',`options_translited`='$optionsTr' where `id`=$id;";
    }
    if ($sql) {
        $sqls = array_chunk($sql, 1000);
        foreach ($sqls as $sql) {
            $sql = implode("\n", $sql);
            try {
                DB::unprepared($sql);
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }
    }
    dd('Done');
});

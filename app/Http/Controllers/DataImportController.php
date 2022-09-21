<?php

namespace App\Http\Controllers;

use App\Helpers\DataImport;
use App\Models\Category;
use App\Models\Domains;
use App\Models\Product;
use App\Services\Conformity;
use App\Services\DirectoryTraversal;
use App\Services\MysqlDbMetaInfo;
use App\Services\Transliterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Kalnoy\Nestedset\DescendantsRelation;

class DataImportController extends Controller
{
    public function structure()
    {
        return Category::tree();
    }

    public function importStructure()
    {
        $importDir = base_path() . '/resources/data/';
        $importFile = $importDir . 'categories.xlsx';
        $sourceDirectory = realpath($importFile);

        $data = DataImport::parse($sourceDirectory);
        $headers = $data['headers'] ?? [];
        $data = $data['data'] ?? [];
        if (!empty($data)) {
            $structure = DataImport::buildStructure($data);
        }
        foreach ($structure as $strKey => $strVal) {
            DB::table('categories')->updateOrInsert([
                'title' => $strVal['title'],
                'slug' => $strVal['slug'],
                'parent_id' => null,
                'image_path' => '/images/catalog/nerjaveushaya_stal.png',
                'image_alt' => $strVal['title'],
                'image_title' => $strVal['title'],
                'has_products' => null
            ]);
            $parent_id = DB::table('categories')->where([
                'title' => $strVal['title'],
                'slug' => $strVal['slug'],
                'parent_id' => null,
            ])->first()->id;
            if(array_key_exists('children', $strVal)):
                foreach ($strVal['children'] as $subKey => $subVal) {
                    DB::table('categories')->updateOrInsert([
                        'title' => $subVal['title'],
                        'slug' => $subVal['slug'],
                        'parent_id' => $parent_id,
                        'image_path' => '/images/catalog/nerjaveushaya_stal.png',
                        'image_alt' => $strVal['title'],
                        'image_title' => $strVal['title'],
                        'has_products' => !array_key_exists('children', $subVal) ? '1' : null
                    ]);
                    $sub_id = DB::table('categories')->where([
                        'title' => $subVal['title'],
                        'slug' => $subVal['slug'],
                        'parent_id' => $parent_id
                    ])->first()->id;
                    if(array_key_exists('children', $subVal)):
                        foreach ($subVal['children'] as $key => $value) {
                            //print_r($value);
                            DB::table('categories')->updateOrInsert([
                                'title' => $value['title'],
                                'slug' => $value['slug'],
                                'parent_id' => $sub_id,
                                'image_path' => '/images/catalog/nerjaveushaya_stal.png',
                                'image_alt' => $strVal['title'],
                                'image_title' => $strVal['title'],
                                'has_products' => '1'
                            ]);
                        }
                    endif;
                }
            endif;
        }
        die;
    }

    public function importItems()
    {
        ini_set('max_execution_time', 1000);
        $sourceDirectory = realpath(config('import.import_directory') . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR);
        $filename = realpath(config('import.import_directory') . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . 'Провода, кабельная продукция парсинг товары_1 NEED IMPORT.xlsx');
        //foreach (glob($sourceDirectory . "/*.xlsx") as $filename) {
            $data = DataImport::parse($filename);
            $headers = $data['headers'] ?? [];
            $data = $data['data'] ?? [];
            if (!empty($data)) {
                $structure = DataImport::buildItems($data, $headers);
            }
        foreach ($structure['data'] as $strKey => $strVal) {
            $prod = DB::table('products')->where($strVal)->first();
            if (!$prod) {
                DB::table('products')->updateOrInsert($strVal);
            }
        }
        //}
        die;
    }

    public function search(Request $request)
    {
        $q = $request->get('q');
        $products = Product::where('title', 'like', '%' . $q . '%')
            ->orWhere('description', 'like', '%' . $q . '%')
            ->orWhere('seo_title', 'like', '%' . $q . '%')
            ->orWhere('options', 'like', '%' . $q . '%')
            ->paginate()->withQueryString();
        View::share('menu', $this->structure());
        $settings = DB::table('settings')->first();
        View::share('settings', $settings);
        $domains = Domains::all();
        View::share('domains', $domains);
        $dir = request()->server('HTTP_HOST');
        $active = Domains::where('domain', $dir)->first();
        View::share('active', $active);
        return view('static.searchResult.index', compact('products', 'q'));
    }

    public function level()
    {
        $roots = Category::where('parent_id', null)->get();
        foreach ($roots as $root) {
            /**
             * @var Category $root
             */

            /**
             * @var DescendantsRelation $descendants
             */
            $descendants = $root->descendants();
            $collection = $descendants->get();
            foreach ($collection as $item) {
                /**
                 * @var Category $item
                 */
                if ($item->name == 'Ферросплавы') {
                    var_export($item);
                }
            }

        }
    }

    public function import(DirectoryTraversal $traversal, Transliterator $transliterator, MysqlDbMetaInfo $dbMetaInfo)
    {
        $sourceDirectory = realpath(config('import.import_directory') . DIRECTORY_SEPARATOR . config('import.data_items_directory'));
        $fileCollection = $traversal->traverse($sourceDirectory);

        $existingTables = $dbMetaInfo->getTables();
        foreach ($fileCollection as $file) {
            if (!is_dir($file)) {
                $tableName = $transliterator->transliterate($file);
                if (!in_array($tableName, $existingTables)) {
                    $existingTables[] = $tableName;
                    //here
                }
            }
        }
        dd($existingTables);
    }

    public function findDoubles(Conformity $conformity)
    {
        $categoies = $conformity->getPrimaryCategoriesForProducts();
        $asliases = $conformity->findAlias();
        var_export($categoies);
//        $result = DataImport::getPrimaryCategoriesForProducts();
    }
}

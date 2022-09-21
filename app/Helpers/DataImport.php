<?php
namespace App\Helpers;

use App\Models\Category;
use App\Services\Conformity;
use App\Services\MysqlDbMetaInfo;
use App\Services\Transliterator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DataImport
{
    #[ArrayShape(['rawData' => "string[]", 'headers' => "string[]", 'data' => "string[]"])]
    public static function parse(string $path): array
    {
        $rawData = static::read($path);
        $rawData = static::sanitizeRawData($rawData);

        $arr['rawData'] = $rawData;
        $arr['headers'] = array_shift($rawData);
        $arr['data'] = $rawData;

        return $arr;
    }

    /**
     * Remove unnecessary (empty) columns
     * Remove unnecessary symbols like ,*&+.$ and other from headers
     *
     * @param array $rawData
     * @return array
     */
    private static function sanitizeRawData(array $rawData): array
    {
        $headers = $rawData[0];
        array_walk($headers, function (&$header, $index) {
            $header = preg_replace("/[,+&*\.`]+/mis", "", $header);
        });
        $headers = array_reverse($headers);
        $count = count($headers);
        foreach ($headers as $h) {
            if (empty($h)) {
                $count--;
            } else {
                break;
            }
        }

        $items = [];
        $passedHeader = false;
        foreach ($rawData as $item) {
            if (!$passedHeader) {
                $items[] = array_chunk(array_reverse($headers), $count)[0];;
                $passedHeader = true;
                continue;
            }
            $items[] = array_chunk($item, $count)[0];
        }
        return $items;
    }

    /**
     * Remove ` symbol from headers
     *
     * @param array $headers
     * @return array
     */
    private static function sanitizeHeaders(array $headers): array
    {
        return array_map(function (string $header) {
            return mb_strtolower(str_replace('`', '', $header));
        }, $headers);
    }

    public static function getItemsDirectory()
    {
        return realpath(config('import.import_directory') . DIRECTORY_SEPARATOR . config('import.data_items_directory'));
    }

    public static function getStructureFilePath()
    {
        return realpath(config('import.import_directory') . DIRECTORY_SEPARATOR . config('import.data_structure_directory') . DIRECTORY_SEPARATOR . config('import.data_structure_file'));;
    }

    private static function read(string $path): array
    {
//        try {
        $reader = IOFactory::createReaderForFile($path);
        /*} catch (\Exception $e) {
//            dd($e->getMessage());
            $message = substr($e->getMessage(), 0, 2048);
            dd($message);
        }*/

        $reader->setReadDataOnly(true);
        $spreadSheet = $reader->load($path);
        return $spreadSheet->getActiveSheet()->toArray();
    }

    public static function transliterateItems($array) {
        return array_map(function (string|null $item) {
            if (!$item) return '';
            $transliterator = app()->get(Transliterator::class);
            /**
             * @var Transliterator $transliterator
             */
            return $transliterator->transliterate($item);
        }, $array);
    }

    /**
     * @param $headers
     * @return string|int
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public static function getCategoryIndex(array $headers): string|int
    {
        $category = 'категория';
        $transliterator = app()->get(Transliterator::class);
        /**
         * @var Transliterator $transliterator
         */
        $category = $transliterator->transliterate($category);
        $tHeaders = static::transliterateItems($headers);

        foreach ($tHeaders as $k => $v) {
            if ($v == $category) {
                return $k;
            }
        }
    }

    /**
     * Creates a hierarchical structure from a two-dimensional array like
     * [
     *      ['item0', null, null],
     *      ['item1', null, null],
     *      [null, 'item1_1', null],
     *      [null, 'item1_2', null],
     *      [null, 'item1_3', null],
     *      ['item2', null, null],
     *      [null, 'item2_1', null],
     *      [null, 'item2_2', null],
     *      [null, null, 'item2_2_1'],
     *      [null, null, 'item2_2_2'],
     *      [null, null, 'item2_2_3'],
     *      [null, 'item3_2', null],
     *      ['item4', null, null],
     *      [null, 'item4_1', null],
     *      [null, null, 'item4_1_1'],
     *      ['item5', null, null],
     * ];
     *
     * @param array $data
     * @return array
     */
    public static function buildStructure(array $data) {
        $structure = [];
        $i = -1;
        $j = -1;
        $k = -1;
        $counter = 0;


        foreach ($data as $value) {
            $counter++;
            if($value[0]) {
                $i++;
                $structure[$i]['title'] = $value[0];
                $structure[$i]['slug'] = Str::slug($value[0]);
//                $j = -1;
//                $k = -1;
            }
            if($value[1]) {
                $j++;
                $structure[$i]['children'][$j]['title'] = $value[1];
                $structure[$i]['children'][$j]['slug'] = Str::slug($value[1]);
//                $k = -1;
                //$arKey = array_keys($structure[$i]['children'], ['name' => $value[1]]);
            }
            if ($value[2]) {
                $k++;
                $structure[$i]['children'][$j]['children'][$k]['title'] = $value[2];
                $structure[$i]['children'][$j]['children'][$k]['slug'] = Str::slug($value[2]);
            }
        }
        return $structure;
    }

    public static function buildItems(array $data, array $headers)
    {
        $output = ['data' => [], 'options' => []];

        $existingProducts = DB::table('products')->select(['id', 'title'])->get()->toArray();
        $existingProducts = array_combine(
            array_column($existingProducts, 'id'),
            array_column($existingProducts, 'title')
        );
        $categories = DB::table('categories')->select(['id', 'title'])->get()->toArray();
        $categories = array_combine(
            array_column($categories, 'title'),
            array_column($categories, 'id')
        );
        foreach ($data as $i => $datum) {
            $temp = array_combine($headers, $datum);
            if (empty($temp)) {
                continue;
            }
            try {
                if (in_array($temp['h1'], $existingProducts)) {
                    continue;
                }
            } catch (\Exception $e) {
                var_dump($temp);
                die;
            }
            $prod = array_slice($temp, 0, 10, 1);
            $xlsOptions = array_map(
                'trim',
                array_filter(array_slice($temp, offset: 10, preserve_keys: 1))
            );

            $prod['seo_title'] = $prod['title'];
            $prod['seo_description'] = $prod['description'];
            $prod['title'] = $prod['h1'];
            unset($prod['h1']);

            $prod['image_path'] = $prod['img'] ?? '';
            unset($prod['img']);
            $prod['image_alt'] = $prod['img alt'] ?? '';
            unset($prod['img alt']);
            $prod['image_title'] = $prod['img title'] ?? '';
            unset($prod['img title']);


            $prod['price'] = $prod['price'] ?? 0;
            $prod['price_title'] = $prod['price title'] ?? 'Договорная';
            unset($prod['price title']);

            if (!array_key_exists($prod['категория'], $categories)) {
                continue;
            }
            $category_id = $prod['category_id'] = $categories[$prod['категория']];
            unset($prod['категория']);

            $prod['slug'] = Str::slug(str_replace(' в [[!+cf.name_rp]]', '', $prod['title']));

            $description = $xlsOptions['Описание'] ?? ($xlsOptions['описание'] ?? '');
            $prod['description'] = $description;
            unset($xlsOptions['Описание'], $xlsOptions['описание']);

            unset($xlsOptions['Скрыть из меню'], $xlsOptions['Шаблон'], $xlsOptions['Опубликован'], $xlsOptions['Показывать в дереве'],);

            $options = [];
            $optionsSlug = [];
            foreach ($xlsOptions as $key => $option) {
                $options[] = "$key=$option";
                $optionsSlug[] = Str::slug($key) . "=$option";

                $output['options'][$key] = [
                    'slug' => Str::slug($key),
                    'title' => $key,
                ];
            }

            $options = implode(';', $options);
            $optionsSlug = implode(';', $optionsSlug);

            $prod['options'] = $options;
            $prod['options_translited'] = $optionsSlug;
            $output['data'][] = $prod;
        }

        return $output;
    }

    public static function buildItemsOld(array $data, array $headers)
    {
        $structure = [];
        $i = -1;
        $j = -1;
        $k = -1;
        $counter = 0;
        /**
         * @var Transliterator $transliterator
         */
        $transliterator = app()->get(Transliterator::class);
        $realHeaders = [
            'title',
            'description',
            'keywords',
            'category_id',
            'name',
            'price',
            'price_title',
            'image_path',
            'image_alt',
            'image_title'
        ];
        foreach($headers as $k => $value) {
            if($k >= 10) {
                $realHeaders[] = $value;
                $notTranslitedHeaders[] = $value;
            }
        }
        foreach ($data as $key => $value) {
            $counter++;
            $products = DB::table('products')->where('name', $value[4])->first();
            if($products) {
                unset($data[$key]);
            }
            foreach ($value as $k => $val) {
                $category = DB::table('categories')->where('title', $value[3])->first();
                if($category) {
                    if($k < 10) {
                        if($realHeaders[$k] !== 'category_id') {
                            if($realHeaders[$k] !== 'name') {
                                $structure['data'][$counter][$realHeaders[$k]] = $val;
                            } else {
                                $structure['data'][$counter][$realHeaders[$k]] = $val;
                                $structure['data'][$counter]['slug'] = Str::slug(
                                    str_replace(' в [[!+cf.name_rp]]', '', $val)
                                );
                            }
                        } else {
                            $structure['data'][$counter][$realHeaders[$k]] = $category->id;
                        }
                    } else {
                        if ($val && $realHeaders[$k] !== 'Описание') {
                            if (!array_key_exists('options', $structure['data'][$counter])) {
                                $structure['data'][$counter]['options'] = $realHeaders[$k] . '=' . $val . ';';
                                $structure['data'][$counter]['options_translited'] = Str::slug(
                                        $realHeaders[$k]
                                    ) . '=' . $val . ';';
                            } else {
                                $structure['data'][$counter]['options'] .= $realHeaders[$k] . '=' . $val . ';';
                                $structure['data'][$counter]['options_translited'] .= Str::slug(
                                        $realHeaders[$k]
                                    ) . '=' . $val . ';';
                                $structure['options'][] = [
                                    'slug' => Str::slug($realHeaders[$k]),
                                    'title' => $realHeaders[$k],
                                    'category_id' => $category->id,
                                    'active' => true
                                ];
                            }
                        } elseif ($realHeaders[$k] == 'Описание') {
                            $structure['data'][$counter]['opisanie'] = $val;
                        }
                    }
                }
            }
        }
        return $structure;
    }

    private static function createTable(string $tableName, $headers)
    {
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function (Blueprint $table) use ($headers) {
                /**
                 * @var Conformity $conformity
                 */
                $conformity = app()->get(Conformity::class);
                $charset = config("database.connections.mysql.charset",'utf8mb4');
                $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');

                $table->charset = $charset;
                $table->collation = $collation;

                $fields = $conformity->getFields($headers);
                $fields = static::sanitizeHeaders($fields);

                $table->id();
                foreach ($fields as $field) {
                    $table->text($field);
                }
                $table->timestamps();
            });

        }
    }

    public static function importProducts(string $filePath): bool
    {
        $categories = [];
//        $filePath = config('import.import_directory') . DIRECTORY_SEPARATOR . config('import.data_items_directory') . DIRECTORY_SEPARATOR . 'Строительные материалы парсинг товары_3 NEED IMPORT.xlsx';
        $data = static::parse($filePath);

        /**
         * @var Transliterator $transliterator
         */
        $transliterator = app()->get(Transliterator::class);

        /**
         * @var MysqlDbMetaInfo $dbInfo
         */
        $dbInfo = app()->get(MysqlDbMetaInfo::class);
        $tables = $dbInfo->getTables();

        /**
         * @var Conformity $conformity
         */
        $conformity = app()->get(Conformity::class);
        $data = static::parse($filePath);
        $headers = $data['headers'];
        $data = $data['data'];
        $categoryIndex = static::getCategoryIndex($headers);
        foreach ($data as $product) {
            /*
             * $tableName is a equal to category name
             */
            $tableName = $transliterator->transliterate($product[$categoryIndex]);

            /**
             * @var Category $category
             */
            $category = $conformity->findCategoryByName($tableName);
            if (!isset($tables[$tableName])) {
                static::createTable($tableName, $headers);
                dd($tableName, 'imported');
                $tables[] = $tableName;
            }
        }
    }

    /*public static function getProduct(int $id)
    {

    }*/

    private static function buildImportProductsPartQuery(string $tableName, array &$data): string
    {

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Domains;
use App\Models\Option;
use App\Models\Product;
use App\Traits\StaticActionTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CatalogController extends Controller
{
    use StaticActionTrait;

    public function __construct()
    {
        View::share('menu', $this->structure());
        $settings = DB::table('settings')->first();
        View::share('settings', $settings);
        $domains = Domains::all();
        View::share('domains', $domains);
        $dir = request()->server('HTTP_HOST');
        $active = Domains::where('domain', $dir)->first();
        View::share('active', $active);
    }


    public function limit()
    {
        return 24;
    }

    public function structure()
    {
        return Category::tree();
    }

    public function catalog()
    {
        $categories = Category::isRoot()->with('children')->orderBy('position')->get();

        $seoData['title'] = 'Каталог';
        return view('static.catalog1.index', ['categories' => $categories, 'seoData' => $seoData]);
    }

    public function subCatalog(Category $category)
    {
        $name = $category->title;
        $categories = $category->children;
        if (!count($categories)) {
            return redirect()->route('catalog.filter', $category);
        }
        $seoData['url'] = route('catalog.category', $category);
        $seoData['title'] = $category->seo_title ?? 'Каталог категории - ' . $name;
        $seoData['h1'] = $category->seo_h1 ?? 'Каталог категории - ' . $name;
        $seoData['description'] = $category->seo_description ?? 'Каталог категории - ' . $name;
        $seoData['keywords'] = $category->keywords ?? $name;
        return view(
            'static.catalog1.show',
            ['categories' => $categories, 'seoData' => $seoData, 'category' => $category]
        );
    }

    public function getFilterCount(Request $request, Category $category)
    {
        $post = $request->post();

        $selected = [];
        if (count($post)) {
            foreach ($post as $filterName => $filterValues) {
                if ($filterName == 'page' || $filterName == '_token' || $filterName == 'sort') {
                    continue;
                }
                $selected[$filterName] = array_map(fn($item) => str_replace('~', ' ', $item),
                    $filterValues);
            }
        }
        $products = Product::query()->where('category_id', $category->id);
        $price = null;
        if ($selected) {
            if (array_key_exists('price', $selected)) {
                $price = Arr::pull($selected, 'price');
            }
            $products->where(function ($query) use ($selected) {
                foreach ($selected as $queryKey => $queryValues) {
                    if ($queryKey == 'price') {
                        continue;
                    }
                    if (count($queryValues) > 1) {
                        foreach ($queryValues as $value) {
                            $query->orWhere('options_translited', 'like', "%$queryKey=$value%");
                        }
                    } else {
                        $query->where('options_translited', 'like', "%$queryKey=$queryValues[0]%");
                    }
                }
            });
        }

        if ($price) {
            $products->whereBetween('price', $price);
        }

        return ['count' => $products->count()];
    }

    public function filterCatalog(Request $request, Category $category)
    {
        $selected = [];
        $selectedStr = [];
        if (count($request->all())) {
            $options = array_combine(
                $category->options()->pluck('slug')->toArray(),
                $category->options()->pluck('title')->toArray()
            );
            foreach ($request->all() as $filterName => $filterValues) {
                if ($filterName == 'page') {
                    continue;
                }
                if (array_key_exists($filterName, $options)) {
                    $selectedStr[] = Str::lower($options[$filterName]) . ' ' . $filterValues;
                } else {
                    $selectedStr[] = $filterName . ' ' . $filterValues;
                }
                $selected[$filterName] = explode(',', str_replace('~', ' ', $filterValues));
            }
        }
        $products = Product::query()->where('category_id', $category->id);
        $productsQuery = clone $products;
        $price = null;
        $sort = null;
        if ($selected) {
            if (array_key_exists('price', $selected)) {
                $price = Arr::pull($selected, 'price');
            }
            if (array_key_exists('sort', $selected)) {
                $sort = Arr::first(Arr::pull($selected, 'sort'));
            }
            $products->where(function ($query) use ($selected, $sort) {
                foreach ($selected as $queryKey => $queryValues) {
                    if ($queryKey == 'price') {
                        continue;
                    }
                    if (count($queryValues) > 1) {
                        foreach ($queryValues as $value) {
                            $query->orWhere('options_translited', 'like', "%$queryKey=$value%");
                        }
                    } else {
                        $query->where('options_translited', 'like', "%$queryKey=$queryValues[0]%");
                    }
                }
            });
        }

        if ($price) {
            $products->whereBetween('price', $price);
        }

        $filters = $this->getFilters($productsQuery, $products, $price, $category);

        if ($sort) {
            $products->orderBy('price', $sort);
        }
        $products = $products->paginate($this->limit())->withQueryString();

        $category->load('siblings');
        $name = $category->seo_title ?? $category->title;
        $seoData['title'] = $name . ' ' . implode(', ', $selectedStr);
        $seoData['category'] = $category;
        $seoData['h1'] = $category->seo_h1 ?? 'Каталог категории - ' . $name;
        $seoData['description'] = $category->seo_description ?? 'Каталог категории - ' . $name;
        $seoData['keywords'] = $category->keywords ?? $name;

        return view('static.catalogFilter.index', [
            'category' => $category,
            'products' => $products,
            'filters' => $filters,
            'selected' => $selected,
            'seoData' => $seoData,
        ]);
    }

    private function getFilters(
        Builder $cleanQuery,
        Builder $filterQuery,
        $price = null,
        Category $category = null
    ): array {
        if (!$cleanQuery) {
            return [];
        }
        $categoryFilters = $category->activeOptions()->get();

        $allOptions = array_column(
            DB::select($this->getSql($cleanQuery->select('options_translited'))),
            'options_translited'
        );
        $queryOptions = array_column(
            DB::select($this->getSql($filterQuery->clone()->select('options_translited'))),
            'options_translited'
        );
        $max = $cleanQuery->max('price');
        $min = $cleanQuery->min('price');
        if (!$price) {
            $price = [$min, $max];
        }
        if ($min || $max) {
            $priceFilter = [
                'price' => [
                    'title' => "Цена",
                    'type' => 'range',
                    'values' => $price,
                    'min' => $min,
                    'max' => $max,
                ],
            ];
        } else {
            $priceFilter = [
                'price' => []
            ];
        }


        $filters = [];
        foreach ($categoryFilters as $filter) {
            /**@var Option $filter */
            $filters[$filter->slug] = [
                'title' => $filter->title,
                'values' => [],
                'type' => 'checkbox',
            ];
        }
        $filters = $this->getOptionArray($queryOptions, 'available', $filters);
        $filters = $this->getOptionArray($allOptions, 'values', $filters);
        $filters = $filters + $priceFilter;
        return $filters;
    }

    private function getOptionArray(array $options, string $type, array $activeFilters): array
    {
        foreach ($options as $i => $option) {
            $props = explode(';', $option);
            foreach ($props as $prop) {
                $title = explode("=", $prop);
                if (count($title) == 2) {
                    $value = $title[1];
                    $title = $title[0];
                    if (array_key_exists($title, $activeFilters)) {
                        if ($title === '') {
                            continue;
                        }
                        if (!array_key_exists($type, $activeFilters[$title])) {
                            $activeFilters[$title][$type] = [];
                        }

                        if (!in_array($value, $activeFilters[$title][$type])) {
                            $activeFilters[$title][$type][] = $value;
                        }
                    }
                }
            }
        }
        return $activeFilters;
    }


    public function product(Product $product)
    {
        $seoData['title'] = $product->seo_title ?? $product->title;
        $seoData['h1'] = $product->title;
        $seoData['keywords'] = $product->title;
        $seoData['description'] = $product->seo_description ?? $product->description;
        $similarProducts = Product::where(
            'slug',
            '!=',
            $product->slug
        )->where(
            'category_id',
            $product->category_id
        )
            ->take(4)->get();
        return view('static.product.index', [
            'product' => $product,
            'similarProducts' => $similarProducts,
            'seoData' => $seoData
        ]);
    }

    private function getSql(Builder $query): string
    {
        $params = array_map(function ($item) {
            return "'{$item}'";
        }, $query->getBindings());
        return Str::replaceArray('?', $params, $query->toSql());
    }
}

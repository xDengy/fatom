<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Domains;
use App\Models\Service;
use App\Models\Settings;
use App\Traits\StaticActionTrait;
use Illuminate\Support\Facades\View;

class StaticController extends Controller
{
    use StaticActionTrait;

    /*public function delivery()
    {
        $title = 'Купить Алюминиевая катанка 9,5 мм А5Е в Краснодаре ⭐ — ООО ФАТОМ цена от 208 руб. купить в Краснодаре с доставкой компания ООО «Фатом»';
        $description = 'В нашей компании вы сможете купить алюминиевая катанка 9,5 мм А5Е по низкой цене. Катанка из алюминия всегда в наличии на наших складах. Для оформления заказа воспользуйтесь формой заявки на нашем сайте, или позвоните по указанному номеру. Осуществляем доставку по всей России.';
        return view('delivery.index', [
            'title' => $title,
            'description' => $description
        ]);
    }*/
    protected $layout = 'layouts.main';

    public function __call($method, $parameters)
    {
        View::share('menu', Category::tree());
        $services = Service::take(4)->get();
        View::share('services', $services);
        $settings = Settings::first();
        View::share('settings', $settings);
        $domains = Domains::all();
        View::share('domains', $domains);
        $dir = request()->server('HTTP_HOST');
        $active = Domains::where('domain', $dir)->first();
        View::share('active', $active);
        return $this->handle($method, $parameters);
    }
}

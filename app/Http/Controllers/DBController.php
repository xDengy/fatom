<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Domains;
use App\Models\SEO;
use App\Models\Service;
use App\Traits\StaticActionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class DBController extends Controller
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

    public function services()
    {
        $services = Service::all();
        $seo = SEO::where('page', 'services')->first();
        return view('static.services.index', ['services' => $services, 'seo' => $seo]);
    }

    public function servicesDetail(Service $service)
    {
        return view('static.services.view', ['service' => $service]);
    }

    public function page(Request $request)
    {
        $seo = SEO::where('page_url', 'like', "%" . $request->path() . "%")->firstOrFail();
        $page = $seo->pageModel;

        return view('static.page.' . $seo->page, ['page' => $page]);
    }

}

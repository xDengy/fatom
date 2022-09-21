<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Domains;
use App\Models\Product;
use App\Models\SEO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    public function __construct()
    {
        View::share('menu', Category::tree());
        $settings = DB::table('settings')->first();
        View::share('settings', $settings);
        $domains = Domains::all();
        View::share('domains', $domains);
        $dir = request()->server('HTTP_HOST');
        $active = Domains::where('domain', $dir)->first();
        View::share('active', $active);
    }

    public function index()
    {
        $id = session()->getId();
        $seo = SEO::where('page', 'cart')->first();
        $cart['items'] = \Cart::session($id)->getContent();
        $cart['totalPrice'] = \Cart::session($id)->getTotal();;
        $cart['count'] = \Cart::session($id)->getTotalQuantity();

        return view('static.cart.index', compact('cart', 'seo'));
    }

    public function add(Product $product, int $count = 1)
    {
        $id = session()->getId();
        $dir = request()->server('HTTP_HOST');
        $city = Domains::where('domain', $dir)->first();
        $cart = \Cart::session($id);
        $cart->add([
            'id'              => $product->id,
            'name'            => str_replace(
                config('domain.replace'),
                $city->domain_city_text,
                $product->title
            ),
            'price'           => $product->price,
            'quantity'        => $count,
            'attributes'      => [
                'img' => $product->image_path,
            ],
            'associatedModel' => $product
        ]);
        $data['items'] = $cart->getContent();
        $data['totalPrice'] = $cart->getTotal();;
        $data['count'] = $cart->getTotalQuantity();
        return response()->json($data);
    }

    public function remove(Product $product)
    {
        $cart = \Cart::session(session()->getId());
        $cart->remove($product->id);

        $data['items'] = $cart->getContent();
        $data['totalPrice'] = $cart->getTotal();
        $data['count'] = $cart->getTotalQuantity();
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $productId = $request->get('id');
        $count = $request->get('count');

        $cart = \Cart::session(session()->getId());
        $cart->update($productId, [
            'quantity' => [
                'relative' => false,
                'value'    => $count
            ]
        ]);

        $item = $cart->get($productId);
        $item['total'] = $item->getPriceSum();
        $item['count'] = $cart->getTotalQuantity();
        return response()->json($item);
    }

    public function updateCart(Request $request)
    {
        $productId = $request->get('id');
        $count = $request->get('count');
        $product = Product::find($productId);
        $dir = request()->server('HTTP_HOST');
        $city = Domains::where('domain', $dir)->first();
        $cart = \Cart::session(session()->getId());
        if ($cart->get($productId)) {
            $cart->update($productId, [
                'quantity' => $count
            ]);
        } else {
            $cart->add([
                'id'              => $product->id,
                'name'            => str_replace(
                    config('domain.replace'),
                    $city->domain_city_text,
                    $product->title
                ),
                'price'           => $product->price,
                'quantity'        => $count,
                'attributes'      => [
                    'img' => $product->image_path,
                ],
                'associatedModel' => $product
            ]);
        }

        $item = $cart->get($productId);
        $item['total'] = $item->getPriceSum();
        $item['count'] = $cart->getTotalQuantity();
        return response()->json($item);
    }

    public function clear()
    {
        $id = session()->getId();
        \Cart::session($id)->clear();

        return redirect()->route('index');
    }

    public function order()
    {
    }
}

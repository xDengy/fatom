<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Mail\Order\AdminNewOrderEmail;
use App\Mail\Order\ClientNewOrderEmail;
use App\Models\Category;
use App\Models\Deliveries;
use Illuminate\Http\Request;
use App\Models\Domains;
use App\Models\Order;
use App\Models\Product;
use App\Models\SEO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class OrderController extends Controller
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

    public function create(OrderRequest $request)
    {
        $cart = \Cart::session(session()->getId())->getContent();
        $data = $request->validated() + ['status'      => Order::STATUS_NEW,
                                         'delivery_id' => Deliveries::first()->id
            ];
        $order = Order::create($data);
        foreach ($cart as $item) {
            $order->products()->syncWithPivotValues($item->id, [
                'count' => $item->quantity,
                'price' => $item->price,
            ], false);
        }
        \Cart::session(session()->getId())->clear();
        try {
            Mail::send(new AdminNewOrderEmail($order));
            Mail::send(new ClientNewOrderEmail($order));
        } catch (\Exception $e) {
            session()->flash('status', 'Something wend wrong');
        }
        return redirect()->route('order.complete');
    }

    public function createOneClick(Request $request)
    {
        $data = $request->all() + ['status'      => Order::STATUS_NEW,
                                         'delivery_id' => Deliveries::first()->id
            ];
        $order = Order::create($data);
            $order->products()->syncWithPivotValues($data['product_id'], [
                'count' => $data['count'],
                'price' => $data['price'],
            ], false);
        try {
            Mail::send(new AdminNewOrderEmail($order));
            Mail::send(new ClientNewOrderEmail($order));
        } catch (\Exception $e) {
            session()->flash('status', 'Something wend wrong');
        }
        return redirect()->back();
    }

    public function deleteProduct(Order $order, Product $product)
    {
        $order->products()->detach($product);
        return redirect()->back();
    }

    public function complete()
    {
        $seo = SEO::where('page', 'cart')->first();
        return view('static.order.complete', compact('seo'));
    }

    public function mail()
    {
        return new AdminNewOrderEmail(Order::find(10));
    }
}

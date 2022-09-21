<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DataImportController;
use App\Http\Controllers\DBController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaticController;
use App\Services\Conformity;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [StaticController::class, 'main'])->name('home');
Route::get('/mail', [OrderController::class, 'mail']);
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/update-cart', [CartController::class, 'updateCart'])->name('cart.update.product');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::post('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::get('/order/complete', [OrderController::class, 'complete'])->name('order.complete');
Route::get('/order/{order}/delete/{product}', [OrderController::class, 'deleteProduct'])->name(
    'order.product.delete'
);

Route::post('/one-click-buy', [OrderController::class, 'createOneClick'])->name('order.create.oneclick');

Route::get('/delivery', [StaticController::class, 'delivery'])->name('delivery');
Route::get('/about', [StaticController::class, 'about'])->name('about');
Route::get('/contacts', [StaticController::class, 'contacts'])->name('contacts');
Route::get('/privacy', [StaticController::class, 'privacy'])->name('privacy');
Route::get('/policy', [StaticController::class, 'policy'])->name('policy');

Route::get('/services', [DBController::class, 'services'])->name('services');
Route::get('/services/{service:slug}', [DBController::class, 'servicesDetail']
)->name('service');

Route::get('/catalog', [CatalogController::class, 'catalog'])->name('catalog');
Route::get('/catalog/{category:slug}', [CatalogController::class, 'subCatalog']
)->name('catalog.category');
Route::get('/category/{category:slug}', [CatalogController::class, 'filterCatalog']
)->name('catalog.filter');
Route::post('/category/{category:slug}', [CatalogController::class, 'getFilterCount']
)->name('get.filter.count');
Route::get('/product/{product:slug}', [CatalogController::class, 'product'])->name(
    'product'
);

Route::post('/modal', [ModalController::class, 'modal'])->name('modal');

Route::get('/xlsx', [DataImportController::class, 'importStructure']);
Route::get('/prods', [StaticController::class, 'search']);
Route::get('/search', [DataImportController::class, 'search'])->name('search');
Route::get('/import', [DataImportController::class, 'import']);

Route::get('/aliases', function (\Illuminate\Http\Request $request, Conformity $conformity) {
    $conformity->getMainItemFieldsList();
});

Route::get('/import-structure', [DataImportController::class, 'importStructure']);

Route::get('/level', [DataImportController::class, 'level']);

Route::get('/doubles', [DataImportController::class, 'findDoubles']);

Route::get('/import-products', function (\Illuminate\Contracts\Container\Container $app) {
    /**
     * @var Conformity $conformity
     */
    $conformity = $app->get(Conformity::class);
    var_export($conformity->findCategoryIdByName('ReshёtchatjNastil'));

});

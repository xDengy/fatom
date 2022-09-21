<?php

declare(strict_types=1);

use App\Orchid\Screens\CategoryEditScreen;
use App\Orchid\Screens\CategoryListScreen;
use App\Orchid\Screens\ContactsEditScreen;
use App\Orchid\Screens\ContactsListScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\OptionEditScreen;
use App\Orchid\Screens\OptionListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\ProductEditScreen;
use App\Orchid\Screens\ProductListScreen;
use App\Orchid\Screens\ProfitEditScreen;
use App\Orchid\Screens\ProfitWorkListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\SEOEditScreen;
use App\Orchid\Screens\SEOListScreen;
use App\Orchid\Screens\ServiceListScreen;
use App\Orchid\Screens\ServicesEditScreen;
use App\Orchid\Screens\SettingsEditScreen;
use App\Orchid\Screens\SettingsListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

use App\Orchid\Screens\ProductExportScreen;
use App\Orchid\Screens\ProductImportScreen;
use App\Orchid\Screens\DomainsListScreen;
use App\Orchid\Screens\DomainsEditScreen;
use App\Orchid\Screens\ZayavkasEditScreen;
use App\Orchid\Screens\ZayavkasListScreen;
use App\Orchid\Screens\DeliveriesEditScreen;
use App\Orchid\Screens\DeliveriesListScreen;
use App\Orchid\Screens\OrderStatusEditScreen;
use App\Orchid\Screens\OrderStatusListScreen;
use App\Orchid\Screens\OrderEditScreen;
use App\Orchid\Screens\OrderListScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Example screen');
    });

Route::screen('domains', DomainsListScreen::class)->name('platform.domains.list');
Route::screen('domainsEdit/{id}', DomainsEditScreen::class)->name('platform.domains.editItem');
Route::screen('domainsEdit', DomainsEditScreen::class)->name('platform.domains.edit');

Route::screen('zayavka', ZayavkasListScreen::class)->name('platform.zayavkas.list');
Route::screen('zayavkaEdit/{id}', ZayavkasEditScreen::class)->name('platform.zayavkas.editItem');
Route::screen('zayavkaEdit', ZayavkasEditScreen::class)->name('platform.zayavkas.edit');

Route::screen('options/{category}', OptionListScreen::class)->name('platform.options.list');
Route::screen('option/{category}/add', OptionEditScreen::class)->name('platform.options.add');
Route::screen('option/{category}/update', OptionEditScreen::class)->name('platform.options.update');

Route::screen('seo', SEOListScreen::class)->name('platform.seo.list');
Route::screen('seoEdit/{id}', SEOEditScreen::class)->name('platform.seo.editItem');
Route::screen('seoEdit', SEOEditScreen::class)->name('platform.seo.edit');

Route::screen('orders', OrderListScreen::class)->name('platform.orders.list');
Route::screen('orderEdit/{id}', OrderEditScreen::class)->name('platform.orders.editItem');
Route::screen('orderEdit', OrderEditScreen::class)->name('platform.orders.edit');

Route::screen('orderStatus', OrderStatusListScreen::class)->name('platform.order_status.list');
Route::screen('orderStatusEdit/{id}', OrderStatusEditScreen::class)->name('platform.order_status.editItem');
Route::screen('orderStatusEdit', OrderStatusEditScreen::class)->name('platform.order_status.edit');

Route::screen('deliveries', DeliveriesListScreen::class)->name('platform.deliveries.list');
Route::screen('deliveriesEdit/{id}', DeliveriesEditScreen::class)->name('platform.deliveries.editItem');
Route::screen('deliveriesEdit', DeliveriesEditScreen::class)->name('platform.deliveries.edit');

Route::screen('services', ServiceListScreen::class)->name('platform.services.list');
Route::screen('servicesEdit/{id}', ServicesEditScreen::class)->name('platform.services.editItem');
Route::screen('servicesEdit', ServicesEditScreen::class)->name('platform.services.edit');

Route::screen('profit_work', ProfitWorkListScreen::class)->name('platform.profit_work.list');
Route::screen('profit_workEdit/{id}', ProfitEditScreen::class)->name(
    'platform.profit_work.editItem'
);
Route::screen('profit_workEdit', ProfitEditScreen::class)->name('platform.profit_work.edit');

Route::screen('product', ProductListScreen::class)->name('platform.product.list');
Route::screen('product_edit/{id}', ProductEditScreen::class)->name('platform.product.editItem');
Route::screen('product_edit', ProductEditScreen::class)->name('platform.product.edit');
Route::screen('product_export', ProductExportScreen::class)->name('platform.product.export');
Route::screen('product_import', ProductImportScreen::class)->name('platform.product.import');

Route::screen('category', CategoryListScreen::class)->name('platform.category.list');
Route::screen('category_edit/{id}', CategoryEditScreen::class)->name('platform.category.editItem');
Route::screen('category_edit', CategoryEditScreen::class)->name('platform.category.edit');

Route::screen('contacts', ContactsListScreen::class)->name('platform.contacts.list');
Route::screen('contacts/{id}', ContactsEditScreen::class)->name('platform.contacts.editItem');
Route::screen('contacts_edit', ContactsEditScreen::class)->name('platform.contacts.edit');


Route::screen('settings', SettingsListScreen::class)->name('platform.settings.list');
Route::screen('settingsEdit/{id}', SettingsEditScreen::class)->name('platform.settings.editItem');
Route::screen('settingsEdit', SettingsEditScreen::class)->name('platform.settings.edit');

Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name(
    'platform.example.advanced'
);

//Route::screen('idea', Idea::class, 'platform.screens.idea');

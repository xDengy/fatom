<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [
            Menu::make('Домены')
                ->icon('safari')
                ->route('platform.domains.list'),

            Menu::make('Заказы')
                ->icon('grid')
                ->route('platform.orders.list'),

            Menu::make('Заявки')
                ->icon('bell')
                ->route('platform.zayavkas.list'),

            Menu::make('Seo')
                ->icon('globe')
                ->route('platform.seo.list'),

            Menu::make('Выгодно работать')
                ->icon('grid')
                ->route('platform.profit_work.list'),

            Menu::make('Товары')
                ->icon('bag')
                ->route('platform.product.list'),

            Menu::make('Экспорт')
                ->icon('sort-amount-asc')
                ->route('platform.product.export'),

            Menu::make('Импорт')
                ->icon('sort-amount-desc')
                ->route('platform.product.import'),

            Menu::make('Категории')
                ->icon('organization')
                ->route('platform.category.list'),

            Menu::make('Контакты')
                ->icon('number-list')
                ->route('platform.contacts.list'),

            Menu::make('Услуги')
                ->icon('event')
                ->route('platform.services.list'),

            Menu::make('Настройки')
                ->icon('wrench')
                ->route('platform.settings.list'),

            Menu::make('Доставка')
                ->icon('grid')
                ->route('platform.deliveries.list'),

            Menu::make('Статусы заказов')
                ->icon('grid')
                ->route('platform.order_status.list'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),
        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make('Profile')
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}

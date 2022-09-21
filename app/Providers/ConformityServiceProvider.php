<?php
/**
 * @created apr 21 2022 12:51
 * @author Evgeny Berezhnoy svd22286@gmail.com
 */

namespace App\Providers;

use App\Services\Transliterator;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class ConformityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Transliterator::class, fn(Container $app) => new Transliterator());
    }
}

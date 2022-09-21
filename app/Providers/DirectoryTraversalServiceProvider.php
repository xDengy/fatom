<?php
/**
 * @created apr 15 2022 18:11
 * @author Evgeny Berezhnoy svd22286@gmail.com
 */
namespace App\Providers;

use App\Services\DirectoryTraversal;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class DirectoryTraversalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DirectoryTraversal::class, fn(Container $app) => new DirectoryTraversal());
    }
}

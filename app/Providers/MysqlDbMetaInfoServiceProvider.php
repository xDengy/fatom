<?php
/**
 * @created apr 18 2022 17:31
 * @author Evgeny Berezhnoy svd22286@gmail.com
 */
namespace App\Providers;

use App\Services\MysqlDbMetaInfo;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class MysqlDbMetaInfoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MysqlDbMetaInfo::class, fn(Container $app) => new MysqlDbMetaInfo());
    }
}

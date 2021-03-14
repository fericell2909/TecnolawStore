<?php

namespace Tecnolaw\Shop;

use Illuminate\Support\ServiceProvider;

class ShopServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function boot()
    {
        //$this->loadTranslationsFrom(__DIR__.'/resources/lang', 'guxShop');
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        //$this->loadViewsFrom(__DIR__.'/resources/views', 'guxShop');
    }

    public function register()
    {

    }
}
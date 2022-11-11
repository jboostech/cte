<?php

namespace Boostech\Cte\Providers;

use Illuminate\Support\ServiceProvider;

class CteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->make('Boostech\Cte\Controllers\HctexController'); // Namespace\NomeController
        //$this->loadViewsFrom(__DIR__ . '/views', 'calculator');
        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    public function boot()
    {
        include __DIR__ . '/../routes/web.php';
    }
}

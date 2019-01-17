<?php

namespace Imarcom\Consolidation;

use Illuminate\Support\ServiceProvider;
use Imarcom\Consolidation\Http\ConsolidationController;

class ConsolidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/consolidation.php' => config_path('consolidation.php'),
        ], 'config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'consolidation');

        if ($this->app->runningInConsole()) {
            $this->commands([
                // @TODO Command Validate
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/consolidation.php', 'consolidation');

        $this->registerRouteMacro();
    }

    protected function registerRouteMacro()
    {
        $router = $this->app['router'];

        $router->macro('consolidation', function () use ($router) {
            $router->get(config('consolidation.url'), '\\' . ConsolidationController::class . '@index')->name('consolidation.index');
            $router->post(config('consolidation.url'), '\\' . ConsolidationController::class . '@accept')->name('consolidation.accept');
        });
    }
}

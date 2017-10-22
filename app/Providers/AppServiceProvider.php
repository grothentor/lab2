<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        //if you want to log sql queries switch on true
        if (false) {
            \DB::listen(function($sql) {
                logger()->debug($sql->sql, [
                    'bindings' => $sql->bindings,
                ]);
            });
        }
    }
}

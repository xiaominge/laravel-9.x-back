<?php

namespace App\Providers;

use App\Foundation\Context\ContextHandler;
use App\Foundation\Response\BusinessHandler;
use App\Foundation\Response\UserBusinessHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        'businessHandler' => BusinessHandler::class,
        'userBusinessHandler' => UserBusinessHandler::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('context', function () {
            return ContextHandler::getInstance();
        });
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

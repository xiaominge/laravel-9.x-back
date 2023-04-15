<?php

namespace App\Providers;

use App\Foundation\Context\ContextHandler as ContextHandler;
use App\Foundation\Response\BusinessHandler;
use App\Foundation\Response\BusinessHandlerUser;
use App\Foundation\ResultReturn\ResultReturn;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $singletons = [
        'businessHandler' => BusinessHandler::class,
        'businessHandlerUser' => BusinessHandlerUser::class,
        'resultReturn' => ResultReturn::class,
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

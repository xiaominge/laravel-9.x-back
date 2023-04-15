<?php

namespace App\Providers;

use App\Foundation\Context\ContextHandler as ContextHandler;
use App\Foundation\Response\BusinessHandler;
use App\Foundation\Response\BusinessHandlerUser;
use App\Foundation\ResultReturn\ResultReturn;
use Illuminate\Pagination\Paginator;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 设置请求开始时间
        context()->request_start_time = get_millisecond();
        // 设置默认分页视图
        Paginator::defaultView('admin.common.page');
        // 监听数据库操作记录
        if (config('app.env') == 'local') {
            db_listen();
        }
    }
}

<?php

use BeyondCode\DumpServer\Dumper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Repositories\RepositoryHandler;
use App\Services\ServiceHandle;
use App\Constant\DateFormat;
use App\Foundation\Util\Html;
use App\Foundation\Logger\LoggerHandler;

if (!function_exists('repository')) {
    function repository()
    {
        return RepositoryHandler::getInstance();
    }
}

if (!function_exists('service')) {
    function service()
    {
        // dd(ServiceHandle::getInstance() === ServiceHandle::getInstance());
        return ServiceHandle::getInstance();
    }
}

if (!function_exists('business_handler')) {
    /**
     * @return App\Foundation\Response\BusinessHandler|mixed
     */
    function business_handler()
    {
        return app('businessHandler');
    }
}

if (!function_exists('business_handler_user')) {
    /**
     * @return App\Foundation\Response\BusinessHandlerUser|mixed
     */
    function business_handler_user()
    {
        return app('businessHandlerUser');
    }
}

if (!function_exists('result_return')) {
    /**
     *
     * @return App\Foundation\ResultReturn\ResultReturn
     */
    function result_return()
    {
        return app('resultReturn');
    }
}

if (!function_exists('logger_handler')) {
    /**
     * Return LoggerHandler object
     *
     * @return LoggerHandler
     */
    function logger_handler()
    {
        return new LoggerHandler();
    }
}

if (!function_exists('context')) {
    /**
     * Gets data that is saved only once in the life cycle
     *
     * @param null $key
     * @param null $default
     * @return \Illuminate\Foundation\Application|mixed
     */
    function context($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('context');
        }

        if (is_array($key)) {
            return app('context')->only($key);
        }

        $value = app('context')->$key;

        return is_null($value) ? value($default) : $value;
    }
}
if (!function_exists('auth_admin')) {
    /**
     * 获取后台登录用户
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function auth_admin()
    {
        return auth('admin')->user();
    }
}

if (!function_exists('auth_admin_id')) {
    /**
     * 获取后台登录用户 ID
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function auth_admin_id()
    {
        return auth('admin')->user()->id;
    }
}

if (!function_exists('redis')) {
    /**
     * redis helpers
     *
     * @param string $connection
     * @return \Illuminate\Redis\Connections\Connection
     */
    function redis($connection = 'default')
    {
        return Redis::connection($connection);
    }
}

if (!function_exists('mongodb')) {
    /**
     * @param $table
     * @return  \Jenssegers\Mongodb\Eloquent\Builder
     */
    function mongodb($table)
    {
        return DB::connection('mongodb')->collection($table);
    }
}

if (!function_exists('is_target_route')) {
    function is_target_route($targetRouteName)
    {
        return Route::currentRouteName() === $targetRouteName;
    }
}

if (!function_exists('set_request_context')) {
    function set_request_context(): void
    {
        $url = urldecode(parse_url(URL::full(), PHP_URL_QUERY));
        $query = $url ? url_query_to_array($url) : [];
        context()->set('request_query', $query);
        context()->set('request_json_payload', request()->json()->all());
        context()->set('request_header', request()->headers->all());
    }
}

if (!function_exists('request_query')) {
    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    function request_query()
    {
        return context('request_query');
    }
}

if (!function_exists('request_json_payload')) {
    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    function request_json_payload()
    {
        return context('request_json_payload');
    }
}

if (!function_exists('request_header')) {
    /**
     * @return \Illuminate\Foundation\Application|mixed
     */
    function request_header()
    {
        return context('request_header');
    }
}

if (!function_exists('d')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param mixed $args
     *
     * @return void
     */
    function d(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
    }
}

if (!function_exists('time_format')) {
    function time_format(int $time, string $format = DateFormat::FULL_FRIENDLY)
    {
        if (empty($time)) return '';
        return date($format, $time);
    }
}

function style()
{
    return Html::style(...func_get_args());
}

function script()
{
    return Html::script(...func_get_args());
}

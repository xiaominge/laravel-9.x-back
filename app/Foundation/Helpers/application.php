<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Constant\DateFormat;
use App\Services\ServiceHandler;
use App\Repositories\RepositoryHandler;
use App\Foundation\Logger\Handler as LoggerHandler;
use App\Foundation\Util\Html\Html;
use App\Foundation\Util\Guzzle\Handler as GuzzleHandler;
use App\Foundation\Util\UserAgent\UserAgent;

if (!function_exists('repository')) {
    function repository()
    {
        return RepositoryHandler::getInstance();
    }
}

if (!function_exists('service')) {
    function service()
    {
        // dd(ServiceHandler::getInstance() === ServiceHandler::getInstance());
        return ServiceHandler::getInstance();
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
     * @return LoggerHandler
     */
    function logger_handler()
    {
        return new LoggerHandler;
    }
}

if (!function_exists('guzzle_handler')) {
    /**
     * 获取 Guzzle Handler
     * @return GuzzleHandler
     */
    function guzzle_handler()
    {
        return new GuzzleHandler;
    }
}

if (!function_exists('guzzle_client')) {
    /**
     * 获取 Guzzle Client
     * @param $config
     * @return \GuzzleHttp\Client
     */
    function guzzle_client($config = [])
    {
        return guzzle_handler()->getClient($config);
    }
}

if (!function_exists('context')) {
    /**
     * Gets data that is saved only once in the life cycle
     * @param $key
     * @param $default
     * @return \Illuminate\Contracts\Foundation\Application|mixed
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

if (!function_exists('user_agent')) {
    function user_agent()
    {
        return new UserAgent;
    }
}

if (!function_exists('storage_disk')) {
    function storage_disk($name = 'public')
    {
        return Storage::disk($name);
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

if (!function_exists('separation_user_agent')) {
    /**
     * Separation user_agent
     *  --- app/1.2.3 (iPhone 17 Plus) iOS/17.2.6
     * @param $userAgent
     * @return array|string[]
     */
    function separation_user_agent($userAgent)
    {
        if (preg_match('/^(.*)\/(.*) \((.*)\) (.*)\/(.*)$/', $userAgent, $matches)) {
            return [
                'os' => $matches[4],
                'os_version' => $matches[5],
                'client_type' => 'mobile app',
                'client_name' => $matches[1],
                'client_version' => $matches[2],
                'device' => $matches[3],
            ];
        } else {
            return [
                'os' => '',
                'os_version' => '',
                'client_type' => 'mobile app',
                'client_name' => '',
                'client_version' => '',
                'device' => '',
            ];
        }
    }
}

if (!function_exists('db_slaves')) {
    /**
     * Get the read-write separation configuration
     * @param $varname
     * @param $default
     * @return array
     */
    function db_slaves($varname, $default = null)
    {
        $dbSlaves = [];

        $slavesEnv = env($varname, $default);
        $slaveConfigList = explode(';', $slavesEnv);
        foreach ($slaveConfigList as $key => $item) {
            $options = explode(',', $item);
            foreach ($options as $option) {
                [$optionKey, $optionValue] = explode(':', $option);
                $dbSlaves[$key][$optionKey] = $optionValue;
            }
        }

        return $dbSlaves;
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
        context()->set('request_query', request()->query->all());
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
        foreach ($args as $argument) {
            dump($argument);
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

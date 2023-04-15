<?php

namespace App\Foundation\Service;

use App\Exceptions\BusinessException;

class ServiceHandler
{
    /**
     * 单例
     * @var object
     */
    protected static $instance;

    /**
     * 所有服务类实例
     * @var array
     */
    protected static $serviceList;

    /**
     * 注册服务名称列表
     * @var array
     */
    protected static $registerList;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * 获取类的实例
     * @return \App\Services\ServiceHandler
     */
    public static function getInstance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * 注册所有的服务
     * @return void
     */
    public static function registerAll()
    {
        foreach (static::$registerList as $name => $class) {
            static::$serviceList[$name] = app($class);
        }
    }

    /**
     * 注册服务
     * @param $name
     * @return void
     */
    public static function register($name)
    {
        static::$serviceList[$name] = app(static::$registerList[$name]);
    }

    /**
     * 获取服务
     * @param $name
     * @return mixed
     * @throws BusinessException
     */
    public function __get($name)
    {
        if (!isset(static::$registerList[$name])) {
            throw new BusinessException("Unregistered service $name! Please add to registerList!");
        } elseif (!isset(static::$serviceList[$name])) {
            static::register($name);
        }

        return static::$serviceList[$name];
    }
}

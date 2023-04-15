<?php

namespace App\Foundation\Repository;

use App\Exceptions\BusinessException;

class RepositoryHandler
{
    /**
     * 单例
     * @var object
     */
    protected static object $instance;

    /**
     * 注册仓库名称列表
     * @var array
     */
    protected static array $registerList = [];

    /**
     * 所有仓库对象集合
     * @var array
     */
    protected static array $repositories = [];


    public function __construct()
    {
    }

    protected function __clone()
    {
    }

    /**
     * 获取类的实例
     * @return \App\Repositories\RepositoryHandler
     */
    public static function getInstance()
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * 注册所有的仓库
     * @return void
     */
    public static function registerAll()
    {
        foreach (static::$registerList as $name => $class) {
            static::$repositories[$name] = app($class);
        }
    }

    /**
     * 注册仓库
     * @param $name
     * @return void
     */
    public static function register($name)
    {
        static::$repositories[$name] = app(static::$registerList[$name]);
    }

    /**
     * 获取仓库
     * @param $name
     * @return mixed
     * @throws BusinessException
     */
    public function __get($name)
    {
        if (!isset(static::$registerList[$name])) {
            throw new BusinessException("Unregistered repository $name! Please add to registerList!");
        } elseif (!isset(static::$repositories[$name])) {
            static::register($name);
        }

        return static::$repositories[$name];
    }
}

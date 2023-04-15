<?php

namespace App\Foundation\Util\Html;

class Html
{
    /**
     * 静态文件别名加载
     * @return string
     */
    protected static function staticFile()
    {
        // 参数，文件别名
        $args = func_get_args();
        // 方法名，文件类型
        $type = debug_backtrace()[1]['function'];
        // 文件类型别名的 key
        $aliasKey = $type . 'Alias';
        // 按文件类型获取的别名数组
        $aliasConfig = \Config::get('extend.' . $aliasKey);
        // 文件版本号
        $version = \Config::get('extend.version');
        // 文件加载 html 代码，数组
        $array = array_map(function ($alias) use ($type, $aliasConfig, $version) {
            if (isset($aliasConfig[$alias])) {
                return app(Builder::class)->$type($aliasConfig[$alias] . "?v=" . $version);
            }
        }, $args);
        // 文件加载 html 代码
        return implode('', array_filter($array));
    }

    /**
     * JS 脚本别名加载
     * @return string
     */
    public static function script()
    {
        return self::staticFile(...func_get_args());
    }

    /**
     * css 文件别名加载
     * @return string
     */
    public static function style()
    {
        return self::staticFile(...func_get_args());
    }
}

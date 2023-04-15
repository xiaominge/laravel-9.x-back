<?php

if (!function_exists('get_millisecond')) {
    /**
     * 以毫秒为单位，获取当前时间
     * 毫微纳皮飞
     * @return int
     */
    function get_millisecond()
    {
        // 高精度数学函数需要字符串类型的参数，所以不用 microtime(true)
        [$microsecond, $second] = explode(" ", microtime());
        // 秒数和微秒（以秒为单位的小数表达）数相加，6位小数精确到微秒
        $second = bcadd($second, $microsecond, 6);
        // 单位由秒转为毫秒
        $millisecond = bcmul($second, 1000, 3);

        return intval($millisecond);
    }
}

if (!function_exists('get_microsecond')) {
    /**
     * 以微秒为单位，获取当前时间
     * @return int
     */
    function get_microsecond()
    {
        // 高精度数学函数需要字符串类型的参数，所以不用 microtime(true)
        [$microsecond, $second] = explode(" ", microtime());
        // 秒数和微秒（以秒为单位的小数表达）数相加，6位小数精确到微秒
        $second = bcadd($second, $microsecond, 6);
        // 单位由秒转为微秒
        $microsecond = bcmul($second, 1000 * 1000);

        return intval($microsecond);
    }
}

if (!function_exists('get_url_query')) {
    /**
     * 将参数变为字符串
     *
     * @param $array_query
     *
     * @return string string 'm=content&c=index&a=lists&catid=6&area=0&author=0&h=0®ion=0&s=1&page=1' (length=73)
     */
    function get_url_query($array_query)
    {
        $tmp = array();
        foreach ($array_query as $k => $param) {
            $tmp[] = $k . '=' . $param;
        }
        $params = implode('&', $tmp);

        return $params;
    }
}

if (!function_exists('disk_path')) {
    /**
     * @param          $path
     * @param string $diskNo
     *
     * @return array
     * @throws Exception
     */
    function disk_path($path, $diskNo = 'disk_0')
    {
        $diskPaths = [
            'disk_0' => 'uploads/'
        ];
        if (!isset($diskPaths[$diskNo])) {
            throw new Exception($diskNo . ' 磁盘设置不存在');
        }
        $diskPrefix = $diskPaths[$diskNo];

        return [
            'disk_path' => $diskPrefix . $path,
        ];
    }
}

if (!function_exists('split_url')) {
    function split_url($url)
    {
        return explode(':', $url);
    }
}

if (!function_exists('selected_or_not')) {
    function selected_or_not($from, $to)
    {
        if ($from === $to) {
            return 'selected';
        }

        return '';
    }
}

if (!function_exists('get_md5_random_str')) {
    /**
     * Gets a random MD5 string
     *
     * @return string
     */
    function get_md5_random_str()
    {
        return md5(time() . uniqid() . str_random(16));
    }
}

if (!function_exists('is_valid_url')) {
    /**
     * 检验 url 是否有效
     * @param $url
     * @return bool
     */
    function is_valid_url($url)
    {
        // 获取头信息数组
        $array = get_headers($url, true);
        // 状态码是否 200
        return preg_match('/200/', $array[0]);
    }
}

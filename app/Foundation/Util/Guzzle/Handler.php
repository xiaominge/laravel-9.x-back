<?php

namespace App\Foundation\Util\Guzzle;

use GuzzleHttp\Client;

class Handler
{
    /**
     * 获取 Client
     * @param $config
     * @return Client
     */
    public function getClient($config = [])
    {
        $defaultConfig = ['timeout' => 2];

        return new Client(array_merge($config, $defaultConfig));
    }
}

<?php

namespace App\Foundation\Logger;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Log;

/**
 * Class Handler
 * @package App\Foundation\Logger
 *
 * @method void emergency(string $message, array $context = [])
 * @method void alert(string $message, array $context = [])
 * @method void critical(string $message, array $context = [])
 * @method void error(string $message, array $context = [])
 * @method void warning(string $message, array $context = [])
 * @method void notice(string $message, array $context = [])
 * @method void info(string $message, array $context = [])
 * @method void debug(string $message, array $context = [])
 */
class Handler
{
    /**
     * 日志类型
     * @var string
     */
    protected string $logType = 'general';

    /**
     * 支持的方法
     * @var array|string[]
     */
    protected array $methods = [
        'notice', 'emergency', 'alert', 'critical',
        'error', 'warning', 'info', 'debug',
    ];

    /**
     * 日志类型字段键值
     */
    const LOG_TYPE_KEY = 'log-type';

    /**
     * 日志请求 ID 字段键值
     */
    const LOG_REQUEST_ID_KEY = 'request-id';

    /**
     * 设置日志类型
     * @param $name
     * @return $this
     */
    public function setLogType($name)
    {
        $this->logType = $name;
        return $this;
    }

    /**
     * 获取日志类型
     * @return string
     */
    public function getLogType()
    {
        return $this->logType;
    }

    /**
     * 调用不同的方法写入日志
     * @param $method
     * @param $args
     * @return void
     * @throws BusinessException
     */
    public function __call($method, $args)
    {
        if (!in_array($method, $this->methods)) {
            throw new BusinessException(sprintf("Method %s not exists!", $method));
        }

        Log::withContext([
            self::LOG_TYPE_KEY => $this->getLogType(),
            self::LOG_REQUEST_ID_KEY => context()->get('request_id'),
        ]);
        Log::channel('stack')->$method(...$args);
    }
}

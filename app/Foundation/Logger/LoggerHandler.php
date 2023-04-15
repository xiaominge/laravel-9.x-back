<?php

namespace App\Foundation\Logger;

use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Log;

/**
 * Class LoggerHandler
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
class LoggerHandler
{
    protected string $logType = 'general';
    protected array $methods = ['notice', 'emergency', 'alert', 'critical', 'error', 'warning', 'info', 'debug'];

    const LOG_TYPE = 'log_type';

    /**
     * Set current logger object custom type
     * @param $name
     * @return $this
     */
    public function setLogType($name)
    {
        $this->logType = $name;

        return $this;
    }

    /**
     * Get custom logger type
     * @return string
     */
    public function getLogType()
    {
        return $this->logType;
    }

    /**
     * Keep different levels of logs for different rooms
     * @param $method
     * @param $args
     * @return void
     */
    public function __call($method, $args)
    {
        if (!in_array($method, $this->methods)) {
            throw new BusinessException(sprintf("Method %s not exists", $method));
        }
        $context = [self::LOG_TYPE => $this->getLogType()];
        $callArgs = isset($args[1]) ? array_merge($context, $args[1]) : $context;
        Log::channel('stack')->$method($args[0], $callArgs);
    }
}

<?php

namespace App\Foundation\Logger\Tap;

use App\Constant\DateFormat;
use Monolog\Formatter\LogstashFormatter;

/**
 * Class ChannelDaily
 * @package App\Foundation\Logger\Tap
 */
class ChannelDaily
{
    /**
     * 自定义给定的日志实例
     * @param \Illuminate\Log\Logger $logger
     * @return void
     */
    public function __invoke($logger)
    {
        $formatter = new LogstashFormatter(config('app.name'));
        $formatter->setDateFormat(DateFormat::FULL_FRIENDLY);

        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
        }
    }
}

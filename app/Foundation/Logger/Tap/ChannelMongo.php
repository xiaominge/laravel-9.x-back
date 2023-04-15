<?php

namespace App\Foundation\Logger\Tap;

use App\Constant\DateFormat;
use Monolog\Formatter\MongoDBFormatter;

/**
 * Class ChannelMongo
 * @package App\Foundation\Logger\Tap
 */
class ChannelMongo
{
    /**
     * 自定义给定的日志实例
     * @param \Illuminate\Log\Logger $logger
     * @return void
     */
    public function __invoke($logger)
    {
        $maxNestingLevel = config('logging.channels.mongo.formatter_with.max_nesting_level', 6);
        $exceptionTraceAsString = config('logging.channels.mongo.formatter_with.exception_trace_as_string', true);
        $formatter = new MongoDBFormatter($maxNestingLevel, $exceptionTraceAsString);

        foreach ($logger->getHandlers() as $handler) {
            $handler->pushProcessor(function ($record) {
                $record['time'] = time();
                $record['datetime'] = date(DateFormat::FULL_FRIENDLY);
                return $record;
            });
            $handler->setFormatter($formatter);
        }
    }
}

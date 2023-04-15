<?php

namespace App\Foundation\Logger;

use Monolog\Formatter\LogstashFormatter;

/**
 * Class FormatHandler
 * @package App\Foundation\Logger
 */
class FormatHandler
{
    /**
     * Set the custom logger format instance.
     * @param $logger
     * @return void
     */
    public function __invoke($logger)
    {
        $formatter = new LogstashFormatter(config('app.name'));
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
        }
    }
}

<?php

namespace App\Foundation\ResultReturn;

use Throwable;

/**
 * Class ResultReturnException
 * @package App\Foundation\ResultReturn
 */
class ResultReturnException extends \Exception
{
    /**
     * ResultReturnException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code);
    }
}

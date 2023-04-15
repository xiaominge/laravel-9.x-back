<?php

namespace App\Foundation\ResultReturn;

use Throwable;

/**
 * Class ResultReturn
 * @package App\Foundation\ResultReturn
 */
class ResultReturn
{
    const RESULT_RETURN_STATUS_SUCCESS = true;
    const RESULT_RETURN_STATUS_FAILED = false;

    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     *
     * @throws ResultReturnException
     */
    public function exception(string $message = "", int $code = 500, Throwable $previous = null)
    {
        throw new ResultReturnException($message, $code, $previous);
    }

    /**
     * Returns a success message
     *
     * @param mixed $data
     *
     * @return ResultReturnStructure
     */
    public function success($data)
    {
        return new ResultReturnStructure(self::RESULT_RETURN_STATUS_SUCCESS, "", $data);
    }

    /**
     * Returns a failure message
     *
     * @param string $msg
     * @param mixed $data
     *
     * @return ResultReturnStructure
     */
    public function failure($msg = '', $data = null)
    {
        return new ResultReturnStructure(self::RESULT_RETURN_STATUS_FAILED, $msg, $data);
    }
}

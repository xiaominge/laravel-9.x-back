<?php

namespace App\Facades;

use App\Constant\BusinessCode;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Http\JsonResponse ok($data = [], $message = "OK", $businessCode = BusinessCode::HTTP_OK, $headers = []);
 * @method static \Illuminate\Http\JsonResponse internalServerError($message = "", $data = [], $businessCode = BusinessCode::HTTP_INTERNAL_SERVER_ERROR, $headers = []);
 * @method static \Illuminate\Http\JsonResponse notFound($message = "", $data = [], $businessCode = BusinessCode::HTTP_NOT_FOUND, $headers = []);
 * @method static \Illuminate\Http\JsonResponse succeed($data, $message, $statusCode, $businessCode, $header = []);
 * @method static \Illuminate\Http\JsonResponse failed($message, $data, $statusCode, $businessCode, $header = []);
 *
 * @see \App\Foundation\Response\BusinessHandler
 *
 */
class BusinessHandler extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'businessHandler';
    }
}

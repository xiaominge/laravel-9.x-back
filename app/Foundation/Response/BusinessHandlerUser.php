<?php

namespace App\Foundation\Response;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use App\Constant\BusinessCode;
use App\Constant\BusinessCodeUser;
use App\Facades\BusinessHandler;

class BusinessHandlerUser
{
    /**
     * 返回成功响应（HTTP 状态码 200）
     * @param $data
     * @param $msg
     * @param $businessCode
     * @return mixed
     */
    public function success($data = [], $msg = '操作成功!', $businessCode = BusinessCode::HTTP_OK)
    {
        return $this->done($data, $msg, $businessCode);
    }

    /**
     * 返回失败响应（HTTP 状态码 200）
     * @param $msg
     * @param $data
     * @param $businessCode
     * @return mixed
     */
    public function fail($msg = '操作失败!', $data = [], $businessCode = BusinessCode::HTTP_INTERNAL_SERVER_ERROR)
    {
        return $this->done($data, $msg, $businessCode);
    }

    /**
     * 获取响应返回值
     * @param $data
     * @param $msg
     * @param $businessCode
     * @return mixed
     */
    public function done($data, $msg, $businessCode)
    {
        return BusinessHandler::ok($data, $msg, $businessCode);
    }

    /**
     * 数据库错误
     *
     * @param string $message
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDbError($message = 'db error', $data = [])
    {
        return BusinessHandler::internalServerError($message, $data, BusinessCodeUser::SERVICE_UPDATE_DB_ERROR);
    }

    /**
     * 找不到用户
     *
     * @param string $message
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFoundUser($message = '找不到用户', $data = [])
    {
        return BusinessHandler::notFound($message, $data, BusinessCodeUser::USER_NOT_FOUND);
    }
}

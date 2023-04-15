<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\RoleStore as RoleStoreJob;
use App\Events\Api\RoleStore as RoleStoreEvent;

class RoleController extends Controller
{
    public function __construct()
    {

    }

    public function store()
    {
        $requestJson = request_json_payload();

        // 派发任务到队列
        RoleStoreJob::dispatch($requestJson)
            ->onQueue('role_store')
            ->delay(now()->addMinute(5));
        // 派发消息给监听者
        RoleStoreEvent::dispatch($requestJson);

        return business_handler()->ok($requestJson);
    }
}

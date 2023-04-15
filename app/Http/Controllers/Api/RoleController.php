<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\RoleStore;

class RoleController extends Controller
{
    public function __construct()
    {

    }

    public function store()
    {
        $requestJson = request_json_payload();

        // 派发任务到队列
        RoleStore::dispatch($requestJson)->onQueue('role_store');

        return business_handler()->ok($requestJson);
    }
}

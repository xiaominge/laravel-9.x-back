<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function __construct()
    {

    }

    public function store()
    {
        $requestJson = request_json_payload();

        logger_handler()->setLogType('role_store')->info($requestJson);

        return business_handler()->ok($requestJson);
    }
}

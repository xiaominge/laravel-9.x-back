<?php

namespace App\Services;

use App\Foundation\Service\ServiceHandler as BaseServiceHandler;

/**
 * @property PermissionService $permission
 * @property UserService $user
 */
class ServiceHandler extends BaseServiceHandler
{
    protected static $registerList = array(
        'permission' => PermissionService::class,
        'user' => UserService::class,
    );
}

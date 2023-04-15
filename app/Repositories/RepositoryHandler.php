<?php

namespace App\Repositories;

use App\Foundation\Repository\RepositoryHandler as RepositoryHandlerBase;

/**
 * @property RoleRepository $role
 * @property AdminRepository $admin
 * @property PermissionRepository $permission
 */
class RepositoryHandler extends RepositoryHandlerBase
{
    /**
     * 注册仓库名称列表
     * @var array|string[]
     */
    protected static array $registerList = [
        'admin' => AdminRepository::class,
        'role' => RoleRepository::class,
        'permission' => PermissionRepository::class,
    ];
}

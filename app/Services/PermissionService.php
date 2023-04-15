<?php

namespace App\Services;

use App\Foundation\Service\Service;
use Illuminate\Support\Facades\Auth;

class PermissionService extends Service
{
    /**
     * 登录用户权限获取
     * @return mixed
     */
    public function getLoginAdminPermission()
    {
        $callback = function ($query) {
            $fields = [
                'permissions.id', 'permissions.name',
                'pid', 'icon', 'route', 'sort',
            ];
            $query->select($fields);
        };

        $permissions = auth_admin()
            ->roles() // 管理员用户的角色
            ->with(['permissions' => $callback]) // 角色的权限
            ->get()
            ->pluck('permissions')
            ->collapse()
            ->unique('id');

        return $permissions;
    }
}

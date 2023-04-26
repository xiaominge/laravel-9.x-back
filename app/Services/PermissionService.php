<?php

namespace App\Services;

use App\Foundation\Service\Service;

class PermissionService extends Service
{
    /**
     * 获取登录管理员的权限
     * @return mixed
     */
    public function getLoginAdminPermission()
    {
        /**
         * 获取登录管理员的角色
         * 预加载角色的权限
         */
        $roles = auth_admin()
            ->roles()
            ->with('permissions:id,name,pid,icon,route,sort')
            ->get();
        $permissions = $roles->pluck('permissions');
        $permissions = $permissions->collapse();
        return $permissions->unique('id');
    }
}

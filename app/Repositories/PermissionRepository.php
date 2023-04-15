<?php

namespace App\Repositories;

use App\Exceptions\BusinessException;
use App\Foundation\Repository\Repository;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository extends Repository
{

    public function model()
    {
        return Permission::class;
    }

    /**
     * 根据 ID 获取权限记录
     * @param $id
     * @return Model
     * @throws BusinessException
     */
    public function findById($id)
    {
        $model = $this->m()->undeleted()->find($id);
        if (!$model) {
            throw new BusinessException('权限不存在或已被删除');
        }
        return $model;
    }

    /**
     * 获取所有权限记录
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->m()->undeleted()->get();
    }

    /**
     * 获取格式化权限列表
     * @return array
     */
    public function allFormatPermissions(): array
    {
        $permissions = $this->all()->keyBy('id')->toArray();
        return $this->formatPermissions($permissions);
    }

    /**
     * 格式化权限列表 -- 增加 level、parentName 字段
     * @param $permissions
     * @param $pid
     * @param $level
     * @return array
     */
    private function formatPermissions($permissions, $pid = 0, $level = 1): array
    {
        static $result = [];
        foreach ($permissions as $permission) {
            if ($permission['pid'] == $pid) {
                $result[] = array_merge($permission, [
                    'level' => $level,
                    'parentName' => $permissions[$pid]['name'] ?? 'ROOT权限',
                ]);
                $this->formatPermissions($permissions, $permission['id'], $level + 1);
            }
        }
        return $result;
    }

    /**
     * 获取根据 pid 生成的树状权限列表
     * @return array
     */
    public function allNestPermissions(): array
    {
        return get_with_children($this->all());
    }

    /**
     * 获取当前权限和所有下级权限ID
     * @param $needs
     * @param $permissions
     * @return mixed
     */
    public function getPermissionsList($needs, $permissions)
    {
        global $list;
        foreach ($needs as $value) {
            $list[] = $value = intval($value);
            $_temp = $permissions->where('pid', $value)->pluck('id')->toArray();
            if ($_temp) {
                $this->getPermissionsList($_temp, $permissions);
            }
        }
        return $list;
    }

    /**
     * 获取当前权限和所有上级权限ID
     * @param $needs
     * @param $permissions
     * @return mixed
     */
    public function getSuperiorPermissions($needs, $permissions)
    {
        global $list;
        foreach ($needs as $value) {
            $list[] = $value = intval($value);
            $_temp = $permissions->where('id', $value)->pluck('pid')->toArray();
            if (array_first($_temp) != 0) {
                $this->getSuperiorPermissions($_temp, $permissions);
            }
        }
        return $list;
    }
}

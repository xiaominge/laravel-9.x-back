<?php

namespace App\Repositories;

use App\Foundation\Repository\Repository;
use App\Exceptions\BusinessException;
use App\Models\Role;

class RoleRepository extends Repository
{

    public function model()
    {
        return Role::class;
    }

    /**
     * 获取所有后台角色
     *
     * @return mixed
     */
    public function getAdminRoles()
    {
        return $this->model->undeleted()->get();
    }

    /**
     * 根据 ID 获得角色记录
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws BusinessException
     */
    public function findById($id)
    {
        $model = $this->model->undeleted()->find($id);
        if (!$model) {
            throw new BusinessException('角色不存在或已被删除');
        }

        return $model;
    }

    public function paginateGetAllRoles($num)
    {
        return $this->m()->undeleted()->paginate($num);
    }
}

<?php

namespace App\Models;

use App\Foundation\Trait\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name 权限名称
 * @property string $description 权限描述
 * @property int $pid 父级权限 顶级权限为 0
 * @property string $icon 权限 菜单图标 只有顶级权限才有
 * @property string $route 权限路由
 * @property int $sort 权限排序
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @method static \Illuminate\Database\Eloquent\Builder|Permission undeleted()
 * @mixin \Eloquent
 */
class Permission extends Eloquent
{
    use Model;

    protected $table = 'permissions';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'route',
        'icon',
        'pid',
        'sort',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 权限关联的角色列表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permission_id', 'role_id')
            ->where('role_permission.deleted_at', 0)
            ->where('roles.deleted_at', 0);
    }

}

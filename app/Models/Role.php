<?php

namespace App\Models;

use App\Foundation\Trait\Model;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name 角色名称
 * @property string $description 角色描述
 * @property string $key 角色英文标识
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Admin> $admins
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @method static \Illuminate\Database\Eloquent\Builder|Role undeleted()
 * @mixin \Eloquent
 */
class Role extends Eloquent
{
    use Model;

    /**
     * 创建时间字段名
     */
    const CREATED_AT = 'created_at';

    /**
     * 更新时间字段名
     */
    const UPDATED_AT = 'updated_at';

    /**
     * 表名
     * @var string
     */
    protected $table = 'roles';

    /**
     * 批量赋值字段
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'key',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [];

    /**
     * 角色下的权限列表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')
            ->using(RolePermission::class)
            ->where('permissions.deleted_at', 0)
            ->wherePivot('deleted_at', 0)
            ->withPivot('id', 'created_at', 'updated_at')
            ->as('role_permission');
    }

    /**
     * 角色下的管理员列表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_role')
            ->using(AdminRole::class)
            ->where('admins.deleted_at', 0)
            ->wherePivot('deleted_at', 0)
            ->withPivot('id', 'created_at', 'updated_at')
            ->as('admin_role');
    }
}

<?php

namespace App\Models;

use App\Foundation\Trait\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $name 用户名
 * @property string $password 密码
 * @property string $email 邮箱
 * @property string|null $remember_token
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at 被删除的用户无法登录
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @method static \Illuminate\Database\Eloquent\Builder|Admin undeleted()
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    use Notifiable, Model;

    protected $table = 'admins';

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $fillable = [
        'name',
        'password',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 获取用户的角色
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'admin_role', 'admin_id', 'role_id')
            ->where('roles.deleted_at', 0)
            ->where('admin_role.deleted_at', 0);
    }
}

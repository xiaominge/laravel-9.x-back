<?php

namespace App\Models;

use App\Foundation\Trait\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\RolePermission
 *
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class RolePermission extends Pivot
{
    use Model;

    /**
     * 表名
     * @var string
     */
    protected $table = 'role_permission';

    /**
     * 主键是否自增
     * @var bool
     */
    public $incrementing = true;
}

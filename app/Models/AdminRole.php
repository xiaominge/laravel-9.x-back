<?php

namespace App\Models;

use App\Foundation\Trait\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AdminRole extends Pivot
{
    use Model;

    /**
     * 表名
     * @var string
     */
    protected $table = 'admin_role';

    /**
     * 主键是否自增
     * @var bool
     */
    public $incrementing = true;
}

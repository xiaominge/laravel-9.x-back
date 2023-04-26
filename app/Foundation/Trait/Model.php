<?php

namespace App\Foundation\Trait;

/**
 * Trait Model
 * @package App\Foundation\Trait
 *
 * @method \Illuminate\Database\Eloquent\Builder undeleted($query)
 *
 */
trait Model
{
    /**
     * 模型构造函数
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->init('id', false);
        parent::__construct($attributes);
    }

    /**
     * 模型初始化
     * @param string $primaryKey
     * @param bool $timestamps
     * @return void
     */
    public function init(string $primaryKey, bool $timestamps): void
    {
        // 设置主键字段
        $this->primaryKey = $primaryKey;
        // 是否自动维护时间戳字段
        $this->timestamps = $timestamps;
    }

    /**
     * 未删除的模型
     * @param $query
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUndeleted($query)
    {
        return $query->where('deleted_at', 0);
    }

    public function fromDateTime($value)
    {
        return strtotime(parent::fromDateTime($value));
    }
}

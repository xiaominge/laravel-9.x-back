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

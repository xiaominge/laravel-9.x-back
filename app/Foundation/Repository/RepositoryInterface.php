<?php

namespace App\Foundation\Repository;

/**
 * Interface RepositoryInterface
 * @package App\Foundation\Repository
 */
interface RepositoryInterface
{
    /**
     * 返回模型类名
     * @return mixed
     */
    public function model();
}

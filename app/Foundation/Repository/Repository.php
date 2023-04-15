<?php

namespace App\Foundation\Repository;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Repository
 * @package App\Foundation\Repository
 */
abstract class Repository implements RepositoryInterface
{
    /**
     * @var Model|\App\Foundation\Trait\Model
     */
    protected $model;
    /**
     * @var \Illuminate\Database\Eloquent\Builder|null
     */
    protected $query = null;

    /**
     * 解析数据模型
     * @throws Exception
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * 解析数据模型
     * @return void
     * @throws Exception
     */
    public function makeModel(): void
    {
        $model = app($this->model());
        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        $this->model = $model;
    }

    /**
     * 获取数据模型
     * @return Model|\App\Foundation\Trait\Model|\Illuminate\Database\Eloquent\Builder
     */
    public function m()
    {
        return $this->model;
    }

    /**
     * 获取查询构造器
     * @param bool $isNew
     * @return \Illuminate\Database\Eloquent\Builder|null
     */
    public function getQuery(bool $isNew = true)
    {
        return $isNew || empty($this->query) ? $this->model->query() : $this->query;
    }
}

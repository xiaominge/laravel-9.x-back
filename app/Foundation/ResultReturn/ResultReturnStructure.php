<?php

namespace App\Foundation\ResultReturn;

/**
 * Class ResultReturnStructure
 * @package App\Foundation\ResultReturn
 *
 * @property bool $status
 * @property string $msg
 * @property mixed $data
 */

/**
 * Class ResultReturnStructure
 * @package App\Foundation\ResultReturn
 */
class ResultReturnStructure
{
    /**
     * @var bool
     */
    private $status;
    /**
     * @var string
     */
    private $msg;
    /**
     * @var mixed
     */
    private $data;

    /**
     * @param string $name
     *
     * @return mixed
     * @throws ResultReturnException
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new ResultReturnException('Attribute ' . $name . ' does not exist');
    }

    /**
     * ResultReturnStructure constructor.
     *
     * @param bool $status
     * @param string $msg
     * @param mixed $data
     */
    public function __construct($status, $msg, $data)
    {
        $this->status = $status;
        $this->msg = $msg;
        $this->data = $data;

        return $this;
    }
}

<?php

namespace App\Events\Api;

use App\Events\Event;

class RoleStore extends Event
{
    public $requestJson;

    public function __construct($requestJson)
    {
        $this->requestJson = $requestJson;
    }
}

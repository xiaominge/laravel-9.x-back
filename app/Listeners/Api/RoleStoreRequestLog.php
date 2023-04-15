<?php

namespace App\Listeners\Api;

use App\Events\Api\RoleStore;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RoleStoreRequestLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\Api\RoleStore $event
     * @return void
     */
    public function handle(RoleStore $event)
    {
        logger_handler()->setLogType('role_store')->info($event->requestJson);
    }
}

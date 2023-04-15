<?php

namespace App\Listeners\Api;

use App\Events\Api\RoleStore;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RoleStoreRequestLog implements ShouldQueue
{

    /**
     * 任务被发送到的连接
     * @var string
     */
    public $connection = 'redis';

    /**
     * 任务被发送到的队列
     * @var string
     */
    public $queue = 'listeners';

    /**
     * 任务被处理的延迟时间（秒）
     * @var string
     */
    public $delay = '300';

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

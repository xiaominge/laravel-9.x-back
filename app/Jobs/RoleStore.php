<?php

namespace App\Jobs;

class RoleStore extends Job
{

    protected $requestJson;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requestJson)
    {
        $this->requestJson = $requestJson;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        logger_handler()->setLogType('role_store')->info($this->requestJson);
    }
}

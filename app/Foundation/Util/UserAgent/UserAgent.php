<?php

namespace App\Foundation\Util\UserAgent;

/**
 * @property UserAgent $os
 * @property UserAgent $osVersion
 * @property UserAgent $device
 * @property UserAgent $clientType
 * @property UserAgent $clientName
 * @property UserAgent $clientVersion
 * @property UserAgent $userAgent
 *
 * Class UserAgent
 * @package App\Foundation\Util\UserAgent
 */
class UserAgent
{
    protected static $has = false;

    public function __get($property)
    {
        if (!self::$has) {
            $this->setUserAgentToContext();
            self::$has = true;
        }
        if (isset($this->$property)) {
            return $this->$property;
        }

        if (method_exists($this, $property)) {
            return $this->$property();
        }

        return '';
    }

    /**
     * Set ua to the context
     */
    public function setUserAgentToContext()
    {
        $ua = separation_user_agent($this->userAgent());
        context()->set('user_agent_os', strtolower(array_get($ua, 'os')));
        context()->set('user_agent_os_version', array_get($ua, 'os_version'));
        context()->set('user_agent_device', array_get($ua, 'device'));
        context()->set('user_agent_client_type', array_get($ua, 'client_type'));
        context()->set('user_agent_client_name', array_get($ua, 'client_name'));
        context()->set('user_agent_client_version', array_get($ua, 'client_version'));
    }

    /**
     * Get the useragent
     *
     * @return null|string|string[]
     */
    private function userAgent()
    {
        return request()->headers->has('user-agent') ? request()->headers->get('user-agent') : '';
    }

    /**
     * Get the operating system
     *
     * @return mixed
     */
    private function os()
    {
        return context()->get('user_agent_os');
    }

    /**
     * Get the system version number
     *
     * @return mixed
     */
    private function osVersion()
    {
        return context()->get('user_agent_os_version');
    }

    /**
     * Get the client driver
     *
     * @return mixed
     */
    private function device()
    {
        return context()->get('user_agent_device');
    }

    /**
     * Get the clientType
     *
     * @return mixed
     */
    private function clientType()
    {
        return context()->get('user_agent_client_type');
    }

    /**
     * Get the clientName
     *
     * @return mixed
     */
    private function clientName()
    {
        return context()->get('user_agent_client_name');
    }

    /**
     * Get the clientVersion
     *
     * @return mixed
     */
    private function clientVersion()
    {
        return context()->get('user_agent_client_version');
    }
}

<?php

namespace FranceIOI\LoginModuleClient\Session;

use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;
use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;

class SessionHandler implements SessionHandlerInterface
{

    protected $prefix = '___LOGINMODULECLIENT_';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        } elseif (session_status() === PHP_SESSION_DISABLED) {
            throw new LoginModuleClientException('Session initialization error');
        }
    }


    public function get($key)
    {
        $key = $this->getKey($key);
        $value = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        return $value;
    }


    public function push($key, $value)
    {
        $_SESSION[$this->getKey($key)] = $value;
    }


    public function pull($key)
    {
        $key = $this->getKey($key);
        $value = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        unset($_SESSION[$key]);
        return $value;
    }


    private function getKey($key)
    {
        return $this->prefix.$key;
    }

}
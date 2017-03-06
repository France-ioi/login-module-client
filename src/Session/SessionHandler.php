<?php

namespace FranceIOI\LoginModuleClient\Session;

use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;
use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;

class Handler implements SessionHandlerInterface
{

    protected $prefix = '___LOGINMODULECLIENT_';

    public function __construct()
    {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        } else throw new LoginModuleClientException('Session initialization error');
    }


    public function get($key)
    {
        $akey = $this->prefix.$key;
        $value = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        unset($_SESSION[$key]);
        return $value;
    }


    public function push($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    public function pull($key)
    {
        $value = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $value;
    }

}
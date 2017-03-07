<?php

namespace FranceIOI\LoginModuleClient;

use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;
use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;

class AccessTokenStore
{

    const SESSION_KEY = 'oauth2_access_token';

    private $session;
    private $access_token;


    public function __construct(SessionHandlerInterface $session) {
        $this->session = $session;
    }


    public function get()
    {
        if (!$this->access_token) {
            if ($this->access_token = $this->session->get(self::SESSION_KEY)) {
                $this->access_token = unserialize($this->access_token);
            }
        }
        return $this->access_token;
    }


    public function set($access_token)
    {
        $this->access_token = $access_token;
        $this->session->push(self::SESSION_KEY, serialize($access_token));
    }

}
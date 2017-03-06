<?php

namespace FranceIOI\LoginModuleClient;

use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;
use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;

class CsrfProtector
{


    const SESSION_KEY = 'oauth2_state';

    private $session;


    public function __construct(SessionHandlerInterface $session)
    {
        $this->session = $session;
    }


    public function pushState($state)
    {
        $this->session->push(self::SESSION_KEY, $state);
    }


    public function validateState($state)
    {
        return $this->session->pull(self::SESSION_KEY) === $state;
    }

}
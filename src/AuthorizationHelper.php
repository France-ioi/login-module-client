<?php

namespace FranceIOI\LoginModuleClient;

use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;
use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;
use FranceIOI\LoginModuleClient\AccessTokenStore;

class AuthorizationHelper
{

    private $provider;
    private $access_token_store;


    public function __construct($provider, SessionHandlerInterface $session)
    {
        $this->provider = $provider;
        $this->access_token_store = new AccessTokenStore($session);
    }


    public function handleRequestParams(array $params)
    {
        $this->validateParams($params);
        $csrf_protector = new CsrfProtector($this->session);
        if(!$csrf_protector->validate($params['state'])) {
            throw new LoginModuleClientException('Invalid state');
        }
        $access_token = $this->provider->getAccessToken('authorization_code', [
            'code' => $params['code']
        ]);
        $this->access_token_store->set($access_token);
    }


    public function queryUser()
    {
        if(!$access_token = $this->access_token_store->get()) {
            throw new LoginModuleClientException('Unauthorized, empty access token');
        }
        if($access_token->hasExpired()) {
            $access_token = $this->provider->getAccessToken('refresh_token', [
                'refresh_token' => $access_token->getRefreshToken()
            ]);
        }
        return $access_token;
    }


    private function validateParams(array $params)
    {
        $missing = array_diff($this->getRequiredParams(), array_keys($params));
        if(!empty($missing)) {
            throw new LoginModuleClientException('Required params missed: ' . implode(', ', $missing));
        }
    }


    private function getRequiredParams()
    {
        return [ 'state', 'code' ];
    }

}
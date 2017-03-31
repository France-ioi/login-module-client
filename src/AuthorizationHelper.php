<?php

namespace FranceIOI\LoginModuleClient;

use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;
use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;
use FranceIOI\LoginModuleClient\AccessTokenStore;
use FranceIOI\LoginModuleClient\CsrfProtector;

class AuthorizationHelper
{

    private $provider;
    private $access_token_store;
    private $session;
    private $scope;


    public function __construct($provider, SessionHandlerInterface $session, array $options)
    {
        $this->provider = $provider;
        $this->session = $session;
        $this->access_token_store = new AccessTokenStore($session);
        $this->scope = $options['scope'];
    }


    public function getUrl()
    {
        $url = $this->provider->getAuthorizationUrl([
            'scope' => $this->scope
        ]);
        $state = $this->provider->getState();
        $csrf_potector = new CsrfProtector($this->session);
        $csrf_potector->pushState($state);
        return $url;
    }


    public function handleRequestParams(array $params)
    {
        if (isset($params['error'])) {
            throw new LoginModuleClientException('Access denied');
        }
        $this->validateParams($params);
        $csrf_protector = new CsrfProtector($this->session);
        if (!$csrf_protector->validateState($params['state'])) {
            throw new LoginModuleClientException('Invalid state');
        }
        $access_token = $this->provider->getAccessToken('authorization_code', [
            'code' => $params['code']
        ]);
        $this->access_token_store->set($access_token);
    }


    public function queryUser()
    {
        if (!$access_token = $this->access_token_store->get()) {
            throw new LoginModuleClientException('Unauthorized, empty access token');
        }
        if ($access_token->hasExpired()) {
            $access_token = $this->provider->getAccessToken('refresh_token', [
                'refresh_token' => $access_token->getRefreshToken()
            ]);
            $this->access_token_store->set($access_token);
        }
        return $this->provider->getResourceOwner($access_token)->toArray();
    }


    private function validateParams(array $params)
    {
        $missing = array_diff($this->getRequiredParams(), array_keys($params));
        if (!empty($missing)) {
            throw new LoginModuleClientException('Required params missed: ' . implode(', ', $missing));
        }
    }


    private function getRequiredParams()
    {
        return [ 'state', 'code' ];
    }

}
<?php

namespace FranceIOI\LoginModuleClient;

use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;
use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;
use FranceIOI\LoginModuleClient\Session\SessionHandler;

class Client
{

    const DEFAULT_OPTIONS = [
        'id' => null,
        'secret' => null,
        'base_url' => 'http://login-module.mobydimk.space'
    ];

    private $options;
    private $session;
    private $provider;


    public function __construct(array $options)
    {
        $options = array_merge(self::DEFAULT_OPTIONS, $options);
        $this->validateOptions($options);
        $this->options = $options;
    }


    public function getRedirectHelper()
    {
        return new RedirectHelper(
            $this->getProvider(),
            $this->getSession(),
            $this->options
    }


    public function getAuthorizationHelper()
    {
        return new AuthorizationHelper(
            $this->getProvider(),
            $this->getSession()
        );
    }


    private function getProvider()
    {
        if(!$this->provider instanceof \League\OAuth2\Client\Provider\GenericProvider) {
            $provider_options = $this->getProviderOptions();
            $this->provider = \League\OAuth2\Client\Provider\GenericProvider($provider_options);
        }
        return $this->provider;
    }


    private function getSession()
    {
        if(isset($this->options['session_handler']) && $this->options['session_handler'] instanceof SessionHandlerInterface) {
            return $this->options['session_handler'];
        }
        if(!$this->session instanceof SessionHandlerInterface) {
            $this->session = new SessionHandler;
        }
        return $this->session;
    }


    private function getProviderOptions()
    {
        return [
            'clientId' => $this->options['id'],
            'clientSecret' => $this->options['secret'],
            'scope' => isset($this->options['scope']) ? $this->options['scope'] : 'account',
            'urlAuthorize' => $this->options['base_url'].'/oauth/authorize',
            'urlAccessToken' => $this->options['base_url'].'/oauth/token',
            'urlResourceOwnerDetails' => $this->options['base_url'].'/api/account'
        ]
    }


    private function validateOptions(array $options)
    {
        $missing = array_diff($this->getRequiredOptions(), array_keys($options));
        if(!empty($missing)) {
            throw new LoginModuleClientException('Required options missed: ' . implode(', ', $missing));
        }
    }


    private function getRequiredOptions()
    {
        return [ 'id', 'secret' ];
    }

}
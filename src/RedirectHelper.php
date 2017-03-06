<?php

namespace FranceIOI\LoginModuleClient;

use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;
use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;
use FranceIOI\LoginModuleClient\Session\SessionHandler;
use FranceIOI\LoginModuleClient\CsrfProtector;

class RedirectHelper
{

    private $provider;
    private $session;
    private $client_id;
    private $base_url;


    public function __construct($provider, $session, array $options) {
        $this->client_id = $options['client_id'];
        $this->base_url = rtrim($options['base_url'], '/');
        $this->provider = $provider;
        $this->session = $session;
    }


    private function formatUrl($path, $redirect_uri) {
        $query = [
            'client_id' => $this->client_id,
        ];
        if($redirect_uri) {
            $query['redirect_uri'] = $redirect_uri;
        }
        return $this->base_url.'/'.$path.http_build_query($query);
    }


    public function getAuthorizationUrl($redirect_uri) {
        $state = $this->provider->getState();
        $csrf_potector = new CsrfProtector($this->session);
        $csrf_potector->pushState($state);
        return $this->provider->getAuthorizationUrl([
            'redirect_uri' => $redirect_uri
        ]);
    }


    public function getAccountUrl($redirect_uri = false)
    {
        return $this->formatUrl('account', $redirect_uri);
    }


    public function getLogoutUrl($redirect_uri = false)
    {
        return $this->formatUrl('logout', $redirect_uri);
    }


    public function getProfileUrl($redirect_uri = false)
    {
        return $this->formatUrl('profile', $redirect_uri);
    }


    public function getPasswordUrl($redirect_uri = false)
    {
        return $this->formatUrl('password', $redirect_uri);
    }


    public function getAuthConnectionsUrl($redirect_uri = false)
    {
        return $this->formatUrl('auth_connections', $redirect_uri);
    }


    public function getBadgeUrl($redirect_uri = false)
    {
        return $this->formatUrl('badge', $redirect_uri);
    }

}
<?php

namespace FranceIOI\LoginModuleClient;

use FranceIOI\LoginModuleClient\Exceptions\LoginModuleClientException;
use FranceIOI\LoginModuleClient\Session\SessionHandlerInterface;
use FranceIOI\LoginModuleClient\Session\SessionHandler;


class RedirectHelper
{

    private $client_id;
    private $base_url;


    public function __construct(array $options) {
        $this->client_id = $options['id'];
        $this->base_url = rtrim($options['base_url'], '/');
    }


    private function formatUrl($path, $redirect_uri, $query = []) {
        $query['client_id'] = $this->client_id;
        if($redirect_uri) {
            $query['redirect_uri'] = $redirect_uri;
        }
        return $this->base_url.'/'.$path.'?'.http_build_query($query);
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
        return $this->formatUrl('profile', $redirect_uri, [
            'all' => 1
        ]);
    }


    public function getPasswordUrl($redirect_uri = false)
    {
        return $this->formatUrl('auth_methods', $redirect_uri, [
            'show_password_form' => '1'
        ]);
    }


    public function getAuthMethodsUrl($redirect_uri = false)
    {
        return $this->formatUrl('auth_methods', $redirect_uri);
    }


    public function getBadgeUrl($redirect_uri = false)
    {
        return $this->formatUrl('badge', $redirect_uri);
    }


    public function getVerificationUrl($redirect_uri = false)
    {
        return $this->formatUrl('verification', $redirect_uri);
    }
}
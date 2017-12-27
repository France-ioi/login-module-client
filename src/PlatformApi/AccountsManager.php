<?php

namespace FranceIOI\LoginModuleClient\Accounts;

class AccountsManager
{

    protected $options;
    protected $api;

    public function __construct(array $options)
    {
        $this->api = new ApiRequest($options);
    }


    public function create($prefix, $amount, $auto_login = false)
    {
        return $this->api->send('/platform_api/accounts_manager/create', [
            'prefix' => $prefix,
            'amount' => $amount,
            'auto_login' => $auto_login
        ]);
    }


    public function delete($prefix)
    {
        return $this->api->send('/platform_api/accounts_manager/delete', [
            'prefix' => $prefix
        ]);
    }
}
<?php

namespace FranceIOI\LoginModuleClient\Accounts;

class AccountsManager
{

    private $options;


    public function __construct(array $options)
    {
        $this->api = new ApiRequest;
    }


    public function create($prefix, $amount)
    {
        return $this->api->send('/platform_api/accounts_manager/create', [
            'prefix' => $prefix,
            'amount' => $amount
        ]);
    }


    public function delete($prefix)
    {
        return $this->api->send('/platform_api/accounts_manager/delete', [
            'prefix' => $prefix
        ]);
    }
}
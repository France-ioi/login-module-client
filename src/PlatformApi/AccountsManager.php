<?php

namespace FranceIOI\LoginModuleClient\PlatformApi;

class AccountsManager
{

    protected $options;
    protected $api;

    public function __construct(array $options)
    {
        $this->api = new ApiRequest($options);
    }


    public function create($params)
    {
        return $this->api->send('/platform_api/accounts_manager/create', $params);
    }


    public function delete($params)
    {
        return $this->api->send('/platform_api/accounts_manager/delete', $params);
    }


    public function unlinkClient($params)
    {
        return $this->api->send('/platform_api/accounts_manager/unlink_client', $params);
    }


    public function getParticipationCodes($params)
    {
        return $this->api->send('/platform_api/accounts_manager/participation_codes', $params);
    }
}
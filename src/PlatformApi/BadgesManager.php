<?php

namespace FranceIOI\LoginModuleClient\PlatformApi;

class BadgesManager
{


    protected $options;
    protected $api;


    public function __construct(array $options)
    {
        $this->api = new ApiRequest($options);
    }


    public function resetDoNotPossess($params)
    {
        return $this->api->send('/platform_api/badges_manager/reset_do_not_possess', $params);
    }

}

<?php

namespace FranceIOI\LoginModuleClient\PlatformApi;

class LtiInterface
{

    protected $options;
    protected $api;

    public function __construct(array $options)
    {
        $this->api = new ApiRequest($options);
    }


    public function sendResult($params)
    {
        return $this->api->send('/platform_api/lti/send_result', $params);
    }

}
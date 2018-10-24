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

    public function entry($params)
    {
        return $this->api->send('/api/lti/entry', $params);
    }

    public function sendResult($params)
    {
        return $this->api->send('/api/lti/send_result', $params);
    }

}
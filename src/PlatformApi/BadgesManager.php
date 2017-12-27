<?php

namespace FranceIOI\LoginModuleClient\Accounts;

class BadgesManager
{

    private $options;


    public function __construct(array $options)
    {
        $this->api = new ApiRequest($options);
    }


    public function resetDoNotPosess($user_id, $code)
    {
        return $this->api->send('/platform_api/badges_manager/reset_do_not_posess', [
            'user_id' => $user_id,
            'code' => $code
        ]);
    }

}
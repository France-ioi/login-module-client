<?php

namespace FranceIOI\LoginModuleClient\Session;

interface SessionHandlerInterface
{

    public function push($key, $value);
    public function get($key);
    public function pull($key);

}
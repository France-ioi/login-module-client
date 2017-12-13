<?php

namespace FranceIOI\LoginModuleClient\Accounts;

class ApiRequest
{

    const CIPHER_METHOD = 'AES-128-ECB';
    protected $http_client;
    protected $options;


    public function __construct($options)
    {
        $this->options = $options;
        $this->http_client = new \GuzzleHttp\Client();
    }


    public function send($path, $params)
    {
        $body = [
            'client_id' => $this->options['id'],
            'data' => $this->encode($params, $this->options['secret'])
        ];

        $res = $this->http_client->post($this->getUrl($path), $body);

        if($res->getStatusCode() == 200) {
            return $this->decode($req->getBody(), $this->options['secret']);
        } else {
            throw new \Excepton($req->getBody());
        }
    }


    public function getUrl($path) {
        return $this->options['base_path'].$path;
    }


    public function encode($params, $secret) {
        $raw = json_encode($params);
        $raw = openssl_encrypt($raw, self::CIPHER_METHOD, $secret);
        return $raw;
    }


    public function decode($body, $secret) {
        $res = json_decode($body);
        $res = openssl_decrypt($res, self::CIPHER_METHOD, $secret);
        return $res;
    }

}
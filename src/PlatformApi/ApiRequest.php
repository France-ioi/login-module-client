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
        $data = [
            'form_params' => [
                'client_id' => $this->options['id'],
                'data' => $this->encode($params, $this->options['secret'])
            ]
        ];
        $res = $this->http_client->request('POST', $this->getUrl($path), $data);
        if($res->getStatusCode() == 200) {
            return $this->decode($res->getBody(), $this->options['secret']);
        } else {
            throw new \Excepton($res->getBody());
        }
    }


    public function getUrl($path) {
        return $this->options['base_url'].$path;
    }


    public function encode($params, $secret) {
        $raw = json_encode($params);
        $raw = openssl_encrypt($raw, self::CIPHER_METHOD, $secret);
        return $raw;
    }


    public function decode($data, $secret) {
        $res = openssl_decrypt($data, self::CIPHER_METHOD, $secret);
        $res = json_decode($res, true);
        return $res;
    }

}
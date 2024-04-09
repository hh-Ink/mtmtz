<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz;

use GuzzleHttp\Client as GuzzleHttpClient;
use Msmm\MtMtz\Contract\RequestInterface;
use Msmm\MtMtz\Utils\SignUtil;

/**
 * 美团客户端
 * Date: 2021-03-31.
 */
class Client
{
    private $secret;

    private $appKey;

    /**
     * @param mixed $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param mixed $appKey
     */
    public function setAppKey($appKey)
    {
        $this->appKey = $appKey;
    }

    public function execute(RequestInterface $req)
    {
        $url = $req->getApiMethodName();
        $data_string = $req->getApiParams();

        $config = [
            'app_key' => $this->appKey,
            'secret' => $this->secret,
            'method' => 'POST',
            'url' => $url,
            'data' => $data_string,
        ];

        $signHeaders = SignUtil::getSignHeaders($config);
        $result = $this->http($url, $signHeaders, $data_string);
        return $req->getResult($result);
    }

    private function http($url, $header, $postFields = null): string
    {
        $client = new GuzzleHttpClient();
        $response = $client->post($url, [
            'headers' => $header,
            'body' => $postFields ? json_encode($postFields) : '{}',
        ]);
        return $response->getBody()->getContents();
    }
}

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
 * 美团客户端类，用于发送请求到美团接口。
 */
class Client
{
    /**
     * 应用的密钥，用于签名。
     */
    private $secret;

    /**
     * 应用的Key，用于标识应用。
     */
    private $appKey;

    /**
     * 设置应用的密钥。
     *
     * @param mixed $secret 应用的密钥
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * 设置应用的Key。
     *
     * @param mixed $appKey 应用的Key
     */
    public function setAppKey($appKey)
    {
        $this->appKey = $appKey;
    }

    /**
     * 执行请求，发送到美团接口。
     *
     * @param requestInterface $req 具有请求信息的接口对象
     * @return mixed 返回处理后的结果
     */
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

        // 生成签名头信息
        $signHeaders = SignUtil::getSignHeaders($config);
        // 发送请求并获取结果
        $result = $this->http($url, $signHeaders, $data_string);
        // 解析并返回处理结果
        return $req->getResult($result);
    }

    /**
     * 发送HTTP请求到指定URL。
     *
     * @param string $url 请求的URL
     * @param array $header 请求的头部信息
     * @param null|string $postFields 请求的POST数据
     * @return string 返回请求的结果
     */
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

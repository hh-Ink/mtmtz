<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Msmm\MtMtz\Contract\RequestInterface;
use Msmm\MtMtz\Exception\JsonInvalidArgumentException;
use Msmm\MtMtz\Utils\SignUtil;
use Psr\Log\LoggerInterface;

/**
 * 美团客户端类，用于发送请求到美团接口。
 */
class Client
{
    /**
     * 日志对象.
     */
    protected $logger;

    /**
     * 请求调试模式.
     */
    protected $debug = false;

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
     * 设置日志.
     * @param mixed $logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    /**
     * 调试模式开关.
     * @param mixed $debug
     */
    public function setDebug($debug)
    {
        $this->logger = $debug;
    }

    /**
     * 执行请求，发送到美团接口。
     *
     * @param RequestInterface $request 具有请求信息的接口对象
     * @return mixed 返回处理后的结果
     * @throws GuzzleException
     * @throws JsonInvalidArgumentException
     */
    public function execute(RequestInterface $request)
    {
        $url = $request->getApiMethodName();
        $dataString = $request->getApiParams();

        $config = [
            'app_key' => $this->appKey,
            'secret' => $this->secret,
            'method' => 'POST',
            'url' => $url,
            'data' => $dataString,
        ];

        // 发送请求并获取结果
        $result = $this->http($url, $config);
        // 解析并返回处理结果
        return $request->getResult($result);
    }

    protected function getStack(): HandlerStack
    {
        // 堆栈设置
        $stack = (new HandlerStack())->create();
        // 设置日志记录驱动
        if ($this->logger instanceof LoggerInterface) {
            $format = 'URL:{url}   BODY:{req_body} RESPONSE:{res_body}';
            $stack->push(
                Middleware::log(
                    $this->logger,
                    new MessageFormatter($format)
                )
            );
        }
        return $stack;
    }

    /**
     * 发送HTTP请求到指定URL。
     *
     * @param mixed $url 请求的URL
     * @param mixed $config
     * @return string 返回请求的结果
     * @throws JsonInvalidArgumentException
     * @throws GuzzleException
     */
    private function http($url, $config): string
    {
        // 生成签名头信息
        $signHeaders = SignUtil::getSignHeaders($config);
        $client = new GuzzleHttpClient([
            'handler' => $this->getStack(),
            'debug' => $this->debug,
        ]);
        $response = $client->post($url, [
            'headers' => $signHeaders,
            'body' => SignUtil::getBodyData($config),
        ]);
        return $response->getBody()->getContents();
    }
}

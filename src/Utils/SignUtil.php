<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Utils;

/**
 * SignUtil 类用于生成API请求的签名头。
 * 它提供了根据请求配置计算签名的方法，包括HTTP方法、内容MD5以及排序后的头信息。
 */
class SignUtil
{
    /**
     * 需要被包含在签名计算中的头列表。
     */
    public const HEAD_LIST = [
        'S-Ca-App',
        'S-Ca-Timestamp',
    ];

    /**
     * 生成签名头信息。
     *
     * @param array $config 请求配置，包括app_key、method、data、params和secret
     * @return array 签名头信息数组
     */
    public static function getSignHeaders($config): array
    {
        $signHeaders = [
            'Content-Type' => 'application/json',
            'S-Ca-App' => $config['app_key'] ?? '',
            'S-Ca-Timestamp' => strval(time() * 1000),
            'S-Ca-Signature-Headers' => implode(',', self::HEAD_LIST),
            'Content-MD5' => self::contentMD5($config),
        ];
        $signHeaders['S-Ca-Signature'] = self::sign($config, $signHeaders);
        return $signHeaders;
    }

    /**
     * 计算签名。
     *
     * @param array $config 请求配置
     * @param array $signHeaders 已构建的签名头信息
     * @return string 签名字符串
     */
    public static function sign($config, $signHeaders): string
    {
        $strSign = self::httpMethod($config) . "\n" .
            self::contentMD5($config) . "\n" .
            self::headers($signHeaders) .
            self::url($config);
        $key = $config['secret'] ?? '';
        $message = $strSign;
        $hash = hash_hmac('sha256', $message, $key, true);
        return base64_encode($hash);
    }

    /**
     * 获取HTTP方法。
     *
     * @param array $config 请求配置
     * @return string HTTP方法字符串
     */
    public static function httpMethod($config): string
    {
        return strtoupper($config['method']);
    }

    /**
     * 计算内容MD5。
     *
     * @param array $config 请求配置
     * @return string 内容MD5字符串
     */
    public static function contentMD5($config): string
    {
        if ($config['method'] === 'POST' && isset($config['data'])) {
            $bodyData = $config['data'] ? json_encode($config['data']) : '{}';
            return base64_encode(md5($bodyData, true));
        }
        return '';
    }

    /**
     * 处理并格式化头信息。
     *
     * @param array $signHeaders 签名头信息数组
     * @return string 格式化后的头信息字符串
     */
    public static function headers($signHeaders): string
    {
        $str = '';
        $sortData = self::objSort($signHeaders);
        $list = array_filter(array_keys($sortData), function ($key) {
            return in_array($key, self::HEAD_LIST);
        });

        foreach ($list as $key) {
            $value = $sortData[$key];
            $str .= $key . ':' . ($value ?: '') . "\n";
        }
        return $str;
    }

    /**
     * 处理URL。
     *
     * @param array $config 请求配置
     * @return string 处理后的URL字符串
     */
    public static function url($config): string
    {
        $reqData = $config['params'] ?? $config['data'] ?? [];
        $path = '/' . implode('/', array_slice(explode('/', $config['url']), 3));

        if ($reqData && $config['method'] === 'GET') {
            $sortObj = self::objSort($reqData);
            $query = http_build_query($sortObj);
            return $path . '?' . $query;
        }
        return $path;
    }

    /**
     * 对数据对象进行排序。
     *
     * @param mixed $data 待排序的数据
     * @return mixed 排序后的数据
     */
    public static function objSort($data)
    {
        ksort($data);
        return $data;
    }
}

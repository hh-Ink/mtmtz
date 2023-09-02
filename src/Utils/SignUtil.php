<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Utils;

class SignUtil
{
    public const HEAD_LIST = [
        'S-Ca-App',
        'S-Ca-Timestamp',
    ];

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

    public static function sign($config, $signHeaders): string
    {
        $strSign = self::httpMethod($config) . "\n" .
            self::contentMD5($config) . "\n" .
            self::headers($signHeaders) .
            self::url($config);
        $key = utf8_encode($config['secret'] ?? '');
        $message = utf8_encode($strSign);
        $hash = hash_hmac('sha256', $message, $key, true);
        return base64_encode($hash);
    }

    public static function httpMethod($config): string
    {
        return strtoupper($config['method']);
    }

    public static function contentMD5($config): string
    {
        if ($config['method'] === 'POST' && isset($config['data'])) {
            $bodyData = $config['data'] ? utf8_encode(json_encode($config['data'])) : utf8_encode('{}');
            return base64_encode(md5($bodyData, true));
        }
        return '';
    }

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

    public static function objSort($data)
    {
        ksort($data);
        return $data;
    }
}

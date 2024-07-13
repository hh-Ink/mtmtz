<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Requests;

use Msmm\MtMtz\Contract\RequestInterface;
use Msmm\MtMtz\Exception\ResultErrorException;
use Msmm\MtMtz\Utils\MtUtilJson;

abstract class AbstractRequest implements RequestInterface
{
    /**
     * 解析结果.
     * @param mixed $response
     * @return mixed
     * @throws \Exception
     */
    public function getResult($response)
    {
        $result = MtUtilJson::decode($response);
        if ($result['code'] !== 0) {
            throw new ResultErrorException($result['message'] ?? '', 301);
        }
        return $result;
    }
}

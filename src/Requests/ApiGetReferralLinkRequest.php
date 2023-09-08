<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Requests;

use Msmm\MtMtz\Contract\RequestInterface;
use Msmm\MtMtz\Utils\Json;

class ApiGetReferralLinkRequest implements RequestInterface
{
    private $actId;

    private $skuViewId;

    private $sid;

    private $linkType;

    /**
     * 请求参数.
     */
    private $apiParams = [];

    /**
     * @return mixed
     */
    public function getActId()
    {
        return $this->actId;
    }

    /**
     * @param mixed $actId
     */
    public function setActId($actId)
    {
        $this->actId = $actId;
        $this->apiParams['actId'] = $actId;
    }

    /**
     * @return mixed
     */
    public function getSkuViewId()
    {
        return $this->skuViewId;
    }

    /**
     * @param mixed $skuViewId
     */
    public function setSkuViewId($skuViewId)
    {
        $this->skuViewId = $skuViewId;
        $this->apiParams['skuViewId'] = $skuViewId;
    }

    /**
     * @return mixed
     */
    public function getSid()
    {
        return $this->sid;
    }

    /**
     * @param mixed $sid
     */
    public function setSid($sid)
    {
        $this->sid = $sid;
        $this->apiParams['sid'] = $sid;
    }

    /**
     * @return mixed
     */
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * @param mixed $linkType
     */
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;
        $this->apiParams['linkType'] = $linkType;
    }

    public function getApiParams(): array
    {
        return $this->apiParams;
    }

    public function getApiMethodName(): string
    {
        return 'https://media.meituan.com/cps_open/common/api/v1/get_referral_link';
    }

    /**
     * 解析结果.
     * @param mixed $response
     * @return mixed
     * @throws \Exception
     */
    public function getResult($response)
    {
        $result = Json::decode($response);
        if ($result['code'] !== 0) {
            throw new \Exception($result['message'] ?? '', 301);
        }
        return $result['data'];
    }
}

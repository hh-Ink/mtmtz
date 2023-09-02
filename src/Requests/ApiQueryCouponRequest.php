<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Requests;

use Msmm\Mtmtz\Contract\RequestInterface;
use Msmm\MtMtz\Utils\Json;

/**
 * 团购API-获取某个城市的一级类目包含的二级类目信息
 * https://union.dianping.com/api/city/{cityId}/categories
 * Date: 2021-03-31.
 */
class ApiQueryCouponRequest implements RequestInterface
{
    private $longitude;

    private $latitude;

    private $priceCap;

    private $priceFloor;

    private $vpSkuViewIds;

    private $listTopiId;

    private $pageSize;

    private $pageNo;

    private $sortField;

    private $ascDescOrder;

    /**
     * 请求参数.
     */
    private $apiParams = [];

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        $this->apiParams['longitude'] = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        $this->apiParams['latitude'] = $latitude;
    }

    /**
     * @return mixed
     */
    public function getPriceCap()
    {
        return $this->priceCap;
    }

    /**
     * @param mixed $priceCap
     */
    public function setPriceCap($priceCap)
    {
        $this->priceCap = $priceCap;
        $this->apiParams['priceCap'] = $priceCap;
    }

    /**
     * @return mixed
     */
    public function getPriceFloor()
    {
        return $this->priceFloor;
    }

    /**
     * @param mixed $priceFloor
     */
    public function setPriceFloor($priceFloor)
    {
        $this->priceFloor = $priceFloor;
        $this->apiParams['priceFloor'] = $priceFloor;
    }

    /**
     * @return mixed
     */
    public function getVpSkuViewIds()
    {
        return $this->vpSkuViewIds;
    }

    /**
     * @param mixed $vpSkuViewIds
     */
    public function setVpSkuViewIds($vpSkuViewIds)
    {
        $this->vpSkuViewIds = $vpSkuViewIds;
        $this->apiParams['vpSkuViewIds'] = $vpSkuViewIds;
    }

    /**
     * @return mixed
     */
    public function getListTopiId()
    {
        return $this->listTopiId;
    }

    /**
     * @param mixed $listTopiId
     */
    public function setListTopiId($listTopiId)
    {
        $this->listTopiId = $listTopiId;
        $this->apiParams['listTopiId'] = $listTopiId;
    }

    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param mixed $pageSize
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
        $this->apiParams['pageSize'] = $pageSize;
    }

    /**
     * @return mixed
     */
    public function getPageNo()
    {
        return $this->pageNo;
    }

    /**
     * @param mixed $pageNo
     */
    public function setPageNo($pageNo)
    {
        $this->pageNo = $pageNo;
        $this->apiParams['pageNo'] = $pageNo;
    }

    /**
     * @return mixed
     */
    public function getSortField()
    {
        return $this->sortField;
    }

    /**
     * @param mixed $sortField
     */
    public function setSortField($sortField)
    {
        $this->sortField = $sortField;
        $this->apiParams['sortField'] = $sortField;
    }

    /**
     * @return mixed
     */
    public function getAscDescOrder()
    {
        return $this->ascDescOrder;
    }

    /**
     * @param mixed $ascDescOrder
     */
    public function setAscDescOrder($ascDescOrder)
    {
        $this->ascDescOrder = $ascDescOrder;
        $this->apiParams['ascDescOrder'] = $ascDescOrder;
    }

    public function getApiParams(): array
    {
        return $this->apiParams;
    }

    public function getApiMethodName(): string
    {
        return 'https://media.meituan.com/cps_open/common/api/v1/query_coupon';
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

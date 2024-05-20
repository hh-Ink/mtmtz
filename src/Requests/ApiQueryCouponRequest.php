<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Requests;

use Msmm\MtMtz\Contract\RequestInterface;
use Msmm\MtMtz\Utils\Json;

/**
 * 团购API-获取某个城市的一级类目包含的二级类目信息
 * https://union.dianping.com/api/city/{cityId}/categories
 * Date: 2021-03-31.
 */
class ApiQueryCouponRequest implements RequestInterface
{
    /**
     * 定位经纬度的经度，请传递经度*100万倍的整形数字，如经度116.404*100万倍为116404000
     * 是否必须：否.
     * @var int
     */
    private $longitude;

    /**
     * 定位经纬度的纬度，请传递纬度*100万倍的整形数字，如纬度39.928*100万倍为39928000
     * 是否必须：否.
     * @var int
     */
    private $latitude;

    /**
     * 筛选商品售卖价格上限
     * 是否必须：否.
     * @var int
     */
    private $priceCap;

    /**
     * 筛选商品价格下限
     * 是否必须：否.
     * @var int
     */
    private $priceFloor;

    /**
     * 商品券ID集合，非必填，若填写该字段则不支持其他筛选条件，集合里ID用英文,隔开。一次最多支持查询20个售卖券ID
     * 是否必须：否.
     * @var string
     */
    private $vpSkuViewIds;

    /**
     * 选品池榜单主题ID，支持查询1:精选，2:今日必推、3:同城热销、4:跟推爆款的商品售卖券
     * 到店业务类型，本项为必填，且只支持传枚举3
     * 是否必须：否.
     * @var int
     */
    private $listTopiId;

    /**
     * 分页大小，不填返回默认分页20
     * 是否必须：否.
     * @var int
     */
    private $pageSize;

    /**
     * 页数，不填返回默认页数1
     * 是否必须：否.
     * @var int
     */
    private $pageNo;

    /**
     * 1）未入参榜单listTopicId时：支持1 售价排序、2 销量排序.
     *
     * 2）入参榜单listTopicId时：
     *
     * 到家业务类型：支持1 售价排序，2 销量降序 3佣金降序；
     *
     * 到店业务类型：支持1 销量降序 2佣金降序；
     *
     * 其他说明：不填则默认为1
     * 是否必须：否
     * @var int
     */
    private $sortField;

    /**
     * 筛选商品佣金值上限.
     *
     * 若商品按照佣金值进行范围筛选，则排序只能按照佣金降序
     *
     * 本字段只支持到店业务类型
     * 是否必须：否
     * @var int
     */
    private $commissionCap;

    /**
     * 筛选商品佣金值下限.
     *
     * 若商品按照佣金值进行范围筛选，则排序只能按照佣金降序
     *
     * 本字段只支持到店业务类型
     * 是否必须：否
     * @var int
     */
    private $commissionFloor;

    /**
     * 商品所属业务一级分类类型：1 到家业务类型，2 到店业务类型 不填则默认1
     * 是否必须：是.
     * @var int
     */
    private $platform;

    /**
     * 当选择到家业务类型时：1 外卖 不填则默认1.
     *
     * 当选择到店业务类型时，商品所属业务二级分类类型：1 到餐，2 到综，不填则默认1
     * 是否必须：否
     * @var int
     */
    private $bizLine;

    /**
     * 仅对到家业务类型生效，未入参榜单listTopicId时：1 升序，2 降序； 入参榜单listTopicId时：1 升序，2 降序，并且仅对sortField为1售价排序的时候生效，其他筛选值不生效； 其他说明：不填则默认为1升序
     * 是否必须：否.
     * @var int
     */
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
     * @return int
     */
    public function getCommissionCap()
    {
        return $this->commissionCap;
    }

    /**
     * @param int $commissionCap
     */
    public function setCommissionCap($commissionCap)
    {
        $this->commissionCap = $commissionCap;
        $this->apiParams['commissionCap'] = $commissionCap;
    }

    /**
     * @return int
     */
    public function getCommissionFloor()
    {
        return $this->commissionFloor;
    }

    /**
     * @param int $commissionFloor
     */
    public function setCommissionFloor($commissionFloor)
    {
        $this->commissionFloor = $commissionFloor;
        $this->apiParams['commissionFloor'] = $commissionFloor;
    }

    /**
     * @return int
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param int $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
        $this->apiParams['platform'] = $platform;
    }

    /**
     * @return int
     */
    public function getBizLine()
    {
        return $this->bizLine;
    }

    /**
     * @param int $bizLine
     */
    public function setBizLine($bizLine)
    {
        $this->bizLine = $bizLine;
        $this->apiParams['bizLine'] = $bizLine;
    }

    /**
     * @return int
     */
    public function getAscDescOrder(): int
    {
        return $this->ascDescOrder;
    }

    /**
     * @param int $ascDescOrder
     */
    public function setAscDescOrder(int $ascDescOrder)
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

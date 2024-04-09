<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Requests;

use Msmm\MtMtz\Contract\RequestInterface;
use Msmm\MtMtz\Utils\Json;

/**
 * API 名称：查询订单
 * API 描述：查询推广的订单明细及佣金信息，一期包括外卖、商品超值券售卖的订单。支持按付款时间或更新时间查询，查询近3个月的订单明细。支持POST方法查询接口。只接受JSON格式。
 */
class ApiQueryOrderRequest implements RequestInterface
{
    /**
     * 二级推广位id，最长64位，不传则返回所有sid的数据
     * 是否必须：否.
     * @var string
     */
    private $sid;

    /**
     * 当platform选择到家及其他业务类型时，业务线枚举 1：外卖订单 WAIMAI 2：闪购 3：酒旅 4：美团电商订单（团好货） 5：医药 6：拼好饭 7：商品超值券包 COUPON 8：买菜 MAICAI 不传则默认传空表示非售卖券包订单类型的全部查询。若输入参数含7 商品超值券包，则只返回商品超值券包订单.
     *
     * 2）当platform选择到店业务类型 时，业务线枚举1:到餐 2: 到综，不填则默认传1
     * 是否必须：否
     * @var array
     */
    private $businessLine;

    /**
     * 订单id，入参后可与业务线标识businessLine配合使用，如查询商品超值券包订单时orderId传券包订单号，businessLine传7； 除此以外其他查询筛选条件不生效，不传业务线标识businessLine则默认仅查非券包订单
     * 是否必须：否.
     * @var string
     */
    private $orderId;

    /**
     * 查询时间类型对应的查询开始时间，10位时间戳表示
     * 是否必须：否.
     * @var int
     */
    private $startTime;

    /**
     * 查询时间类型对应的查询结束时间，10位时间戳表示
     * 是否必须：否.
     * @var int
     */
    private $endTime;

    /**
     * 页码，默认1，从1开始
     * 是否必须：否.
     * @var int
     */
    private $page;

    /**
     * 每页限制条数，默认20，最大支持20
     * 是否必须：否.
     * @var int
     */
    private $limit;

    /**
     * 查询时间类型，枚举值， 1 按订单支付时间查询， 2 按照更新时间查询， 默认为1
     * 是否必须：否.
     * @var int
     */
    private $queryTimeType;

    /**
     * 交易类型，1表示CPS，2表示CPA
     * 是否必须：否.
     * @var int
     */
    private $scrollId;

    /**
     * 商品所属业务一级分类类型：1 到家及其他业务类型，2 到店业务类型 不填则默认1
     * 是否必须：否.
     * @var int
     */
    private $platform;

    /**
     * 请求参数.
     */
    private $apiParams = [];

    /**
     * @return mixed
     */
    public function getSid()
    {
        return $this->sid;
    }

    /**
     * @return mixed
     */
    public function getBusinessLine()
    {
        return $this->businessLine;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return mixed
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return mixed
     */
    public function getQueryTimeType()
    {
        return $this->queryTimeType;
    }

    /**
     * @return mixed
     */
    public function getScrollId()
    {
        return $this->scrollId;
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
     * @param mixed $sid
     */
    public function setSid($sid)
    {
        $this->sid = $sid;
        $this->apiParams['sid'] = $sid;
    }

    /**
     * @param mixed $businessLine
     */
    public function setBusinessLine($businessLine)
    {
        $this->businessLine = $businessLine;
        $this->apiParams['businessLine'] = $businessLine;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        $this->apiParams['orderId'] = $orderId;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        $this->apiParams['startTime'] = $startTime;
    }

    /**
     * @param mixed $endTime
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        $this->apiParams['endTime'] = $endTime;
    }

    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;
        $this->apiParams['page'] = $page;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        $this->apiParams['limit'] = $limit;
    }

    /**
     * @param mixed $queryTimeType
     */
    public function setQueryTimeType($queryTimeType)
    {
        $this->queryTimeType = $queryTimeType;
        $this->apiParams['queryTimeType'] = $queryTimeType;
    }

    /**
     * @param mixed $scrollId
     */
    public function setScrollId($scrollId)
    {
        $this->scrollId = $scrollId;
        $this->apiParams['scrollId'] = $scrollId;
    }

    public function getApiParams(): array
    {
        return $this->apiParams;
    }

    public function getApiMethodName(): string
    {
        return 'https://media.meituan.com/cps_open/common/api/v1/query_order';
    }

    /**
     * 解析结果.
     * @param mixed $response
     * @throws \Exception
     */
    public function getResult($response): array
    {
        $result = Json::decode($response);
        if ($result['code'] !== 0) {
            throw new \Exception($result['message'] ?? '', 301);
        }
        return $result;
    }
}

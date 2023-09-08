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
    private $actId; //	Long	非必填	活动物料id，我要推广-活动推广中第一列的id信息，不传则返回所有actId的数据，但是不会标记对应的actid，建议查询订单时传入actId

    private $sid;   //	String	非必填	二级推广位id，最长64位，不传则返回所有sid的数据

    private $businessLine;  //	List<Integer>	非必填	业务线列表：1：外卖订单 WAIMAI， 2：闪购， 3：酒旅， 4：美团电商订单（团好货）， 5：医药 6：拼好饭， 7：商品超值券包 COUPON， 8：买菜 MAICAI， 不传则默认传空表示非售卖券包订单类型的全部查询； 一期仅支持返回外卖和商品超值券包的订单

    private $orderId;   //	String	非必填	订单id，入参后其他条件不生效，本期只能查非商品券类型的订单

    private $startTime; //	Integer	非必填	查询时间类型对应的查询开始时间，10位时间戳表示

    private $endTime;   //	Integer	非必填	查询时间类型对应的查询结束时间，10位时间戳表示

    private $page;  //	Integer	非必填	页码，默认1，从1开始

    private $limit; //	Integer	非必填	每页限制条数，默认20，最大支持20

    private $queryTimeType; //	Integer	非必填	查询时间类型，枚举值， 1 按订单支付时间查询， 2 按照更新时间查询， 默认为1

    private $scrollId; //	String	非必填	分页id（暂未使用，预留）

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
     * @param mixed $actId
     */
    public function setActId($actId)
    {
        $this->actId = $actId;
        $this->apiParams['actId'] = $actId;
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

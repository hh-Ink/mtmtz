<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Requests;

/**
 * API 名称：查询订单
 * API 描述：查询推广的订单明细及佣金信息，一期包括外卖、商品超值券售卖的订单。支持按付款时间或更新时间查询，查询近3个月的订单明细。支持POST方法查询接口。只接受JSON格式。
 */
class ApiQueryOrderRequest extends AbstractRequest
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
     * 订单品类
     * 1）当platform为1，当businessLine为11时，
     * 枚举值支持：
     * 大型连锁商超便利店(12)，
     * 小型商超便利店(14)，
     * 线上便利店(21)，
     * 日百服饰(128)，
     * 数码家电(106)，
     * 美妆日化(107)，
     * 母婴玩具(108)，
     * 宠物(110)，
     * 生鲜食材(24)，
     * 鲜花(16)，
     * 水果(15)，
     * 酒饮(26)，
     * 休闲食品(25)，
     * 旗舰店(137)，
     * 其他(-2)；.
     *
     * 2）当platform为1，当businessLine为9时，
     * 枚举值支持：
     * 进群(1)，
     * 下单(2)，
     * 首关注(3)；
     *
     * 3）当platform为2，当businessLine为3时，
     * 枚举值支持：
     * 酒店(209)，
     * 非标住宿(2327)；
     *
     * 4）当platform为2，当businessLine为2时，
     * 枚举值支持：
     * 休闲娱乐(3)，
     * 结婚(338)，
     * 教育培训(289)，
     * 养车/用车(390)，
     * 运动健身(206)，
     * 家居(600)，
     * 购物(379)，
     * 亲子(389)，
     * 医疗健康(450)，
     * 生活服务(4)，
     * K歌(1853)，
     * 宠物(1861)，
     * 其他(-1)
     *
     * 4）当businessLine为999时，
     * 枚举值支持
     * 到餐-纯新用户(1001),
     * 到餐-召回用户(1002),
     * 到综-纯新用户(1003),
     * 到综-召回用户(1004),
     * 闪购-纯新用户(1005),
     * 闪购-召回用户(1006),
     * 外卖-纯新用户(1007),
     * 外卖-沉默用户(1008),
     * 外卖-预警用户(1009),
     * 外卖-流失用户(1010)
     *
     * 是否必须：否.
     * @var array<int>
     */
    private $categoryIds;

    /**
     * 活动物料id，我要推广-活动推广中第一列的id信息，不传则返回所有actId的数据，省钱包订单不传
     * 是否必须：否.
     * @var int
     */
    private $actId;

    /**
     * 交易类型，1表示CPS，2表示CPA
     * 是否必须：否.
     * @var int
     */
    private $tradeType;

    /**
     * 订单分页查询方案选择，不填则默认为1。
     *
     * 1 分页查询（最多能查询到1万条订单），当选择本查询方案，page参数不能为空。
     * 此查询方式后续不再维护，建议使用2逐页查询。
     *
     * 2 逐页查询（不限制查询订单数，只能逐页查询，不能指定页数），
     * 当选择本查询方案，需配合scrollId参数使用，省钱包查询仅支持2
     *
     * 是否必须：否.
     * @var int
     */
    private $searchType;

    /**
     * 省份名称列表.
     *
     * 省份名称列表，多个用英文逗号隔开，最多支持5个。
     *
     * 是否必须：否.
     * @var array<string>
     */
    private $cityNames;

    /**
     * 请求参数.
     */
    private $apiParams = [];

    public function getSid()
    {
        return $this->sid;
    }

    public function getBusinessLine()
    {
        return $this->businessLine;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getQueryTimeType()
    {
        return $this->queryTimeType;
    }

    public function getScrollId()
    {
        return $this->scrollId;
    }

    public function getPlatform()
    {
        return $this->platform;
    }

    public function setPlatform($platform)
    {
        $this->platform = $platform;
        $this->apiParams['platform'] = $platform;
    }

    public function setSid($sid)
    {
        $this->sid = $sid;
        $this->apiParams['sid'] = $sid;
    }

    public function setBusinessLine($businessLine)
    {
        $this->businessLine = $businessLine;
        $this->apiParams['businessLine'] = $businessLine;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        $this->apiParams['orderId'] = $orderId;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
        $this->apiParams['startTime'] = $startTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
        $this->apiParams['endTime'] = $endTime;
    }

    public function setPage($page)
    {
        $this->page = $page;
        $this->apiParams['page'] = $page;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        $this->apiParams['limit'] = $limit;
    }

    public function setQueryTimeType($queryTimeType)
    {
        $this->queryTimeType = $queryTimeType;
        $this->apiParams['queryTimeType'] = $queryTimeType;
    }

    public function setScrollId($scrollId)
    {
        $this->scrollId = $scrollId;
        $this->apiParams['scrollId'] = $scrollId;
    }

    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    public function setCategoryIds(array $categoryIds): void
    {
        $this->categoryIds = $categoryIds;
        $this->apiParams['categoryIds'] = $categoryIds;
    }

    public function getActId(): int
    {
        return $this->actId;
    }

    public function setActId(int $actId): void
    {
        $this->actId = $actId;
        $this->apiParams['actId'] = $actId;
    }

    public function getTradeType(): int
    {
        return $this->tradeType;
    }

    public function setTradeType(int $tradeType): void
    {
        $this->tradeType = $tradeType;
        $this->apiParams['tradeType'] = $tradeType;
    }

    public function getSearchType(): int
    {
        return $this->searchType;
    }

    public function setSearchType(int $searchType): void
    {
        $this->searchType = $searchType;
        $this->apiParams['searchType'] = $searchType;
    }

    public function getCityNames(): array
    {
        return $this->cityNames;
    }

    public function setCityNames(array $cityNames): void
    {
        $this->cityNames = $cityNames;
        $this->apiParams['cityNames'] = $cityNames;
    }

    public function getApiParams(): array
    {
        return $this->apiParams;
    }

    public function getApiMethodName(): string
    {
        return 'https://media.meituan.com/cps_open/common/api/v1/query_order';
    }
}

<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace Msmm\MtMtz\Requests;

class ApiGetReferralLinkRequest extends AbstractRequest
{
    /**
     * ID，我要推广-活动推广中第一列的id信息（和商品id、活动链接三选一填写，不能全填）
     * 是否必须：否.
     * @var string
     */
    private $actId;

    /**
     * 商品id，对商品券查询接口返回的skuViewid（和活动物料ID、活动链接三选一，不能全填）
     * 是否必须：否.
     * @var string
     */
    private $skuViewId;

    /**
     * 二级媒体身份标识，用于渠道效果追踪，限制64个字符，仅支持英文、数字和下划线
     * 是否必须：否.
     * @var string
     */
    private $sid;

    /**
     * 链接类型，枚举值：1 H5长链接；2 H5短链接；3 deeplink(唤起)链接；4 微信小程序唤起路径径
     * 是否必须：否.
     * @var int
     */
    private $linkType;

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
     * 分享文案：支持媒体选择小红书 or 微信社群风格的分享文案 出参增加 shareText 字段
     * 1 代表小红书风格文案
     * 2 代表微信社群风格文案.
     *
     * 是否必须：否
     * @var int
     */
    private $shareTextType;

    /**
     * 活动链接.
     * @var string
     */
    private $text;

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

    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
        $this->apiParams['text'] = $text;
    }

    public function getShareTextType()
    {
        return $this->shareTextType;
    }

    public function setShareTextType($shareTextType)
    {
        $this->shareTextType = $shareTextType;
        $this->apiParams['shareTextType'] = $shareTextType;
    }

    public function getApiParams(): array
    {
        return $this->apiParams;
    }

    public function getApiMethodName(): string
    {
        return 'https://media.meituan.com/cps_open/common/api/v1/get_referral_link';
    }
}

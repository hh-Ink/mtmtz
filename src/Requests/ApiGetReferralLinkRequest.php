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
     * 单个转链链接
     * 只支持到家（外卖商品券、医药）商品链接、到店（到店美食、休闲生活、酒店、门票）商品链接、活动物料链接。
     *
     * 活动链接，即想要推广的目标链接
     * 出参会返回成自己可推的链接，限定为当前可推广的活动链接或者商品券链接，请求内容尽量保持在200字以内，
     * 链接类型目前支持长链、短链、deeplink(唤起)链接、圈圈小程序唤起路径、美团小程序活动链接
     *
     * @var string
     */
    private $text;

    /**
     * 链接类型列表，(linkType和linkTypeList必传一个，linkType和linkTypeList都传时，只处理linkTypeList)。枚举值：1 H5长链接；2 H5短链接；3 deeplink(唤起)链接；4 微信小程序唤起路径；5 团口令；6 小程序码;注：团口令、h5短链、小程序二维码有效期60天 ，其余无限制
     * 是否必须：否.
     * @var array<int>
     */
    private $linkTypeList;

    /**
     * 批量转链链接。只支持到家（外卖商品券、医药）商品链接、到店（到店美食、休闲生活、酒店、门票）商品链接、活动物料链接。活动链接，即想要推广的目标链接，出参会返回成自己可推的链接，限定为当前可推广的活动链接或者商品券链接，请求内容尽量保持在200字以内，请求链接数量控制在20条以下, 链接类型目前支持长链、短链、deeplink(唤起)链接、圈圈小程序唤起路径、美团小程序活动链接
     * 是否必须：否.
     * @var array<string>
     */
    private $textList;

    /**
     * 请求参数.
     */
    private $apiParams = [];

    public function getActId()
    {
        return $this->actId;
    }

    public function setActId($actId)
    {
        $this->actId = $actId;
        $this->apiParams['actId'] = $actId;
    }

    public function getSkuViewId()
    {
        return $this->skuViewId;
    }

    public function setSkuViewId($skuViewId)
    {
        $this->skuViewId = $skuViewId;
        $this->apiParams['skuViewId'] = $skuViewId;
    }

    public function getSid()
    {
        return $this->sid;
    }

    public function setSid($sid)
    {
        $this->sid = $sid;
        $this->apiParams['sid'] = $sid;
    }

    public function getLinkType()
    {
        return $this->linkType;
    }

    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;
        $this->apiParams['linkType'] = $linkType;
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

    public function getBizLine()
    {
        return $this->bizLine;
    }

    public function setBizLine($bizLine)
    {
        $this->bizLine = $bizLine;
        $this->apiParams['bizLine'] = $bizLine;
    }

    public function getText()
    {
        return $this->text;
    }

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

    public function setLinkTypeList($linkTypeList)
    {
        $this->linkTypeList = $linkTypeList;
        $this->apiParams['linkTypeList'] = $linkTypeList;
    }

    public function getLinkTypeList(): array
    {
        return $this->linkTypeList;
    }

    public function setTextList($textList)
    {
        $this->textList = $textList;
        $this->apiParams['textList'] = $textList;
    }

    public function getTextList(): array
    {
        return $this->textList;
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

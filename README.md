# 美团美天赚-sdk

## 说明
提供了美团美天赚的接入鉴权封装及请求类的抽象

## 安装
```shell
composer require msmm/mtmtz
```

## 使用

```
<?php

declare(strict_types=1);
/**
 * This file is part of msmm.
 */

namespace App\Helper\Sdk;

use Msmm\MtMtz\Client;
use Msmm\MtMtz\Requests\ApiQueryOrderRequest;

class ToolMtMTZ
{
    /**
     * 获取订单.
     * @throws \Exception
     */
    public function pullOrder(): array {
        $client = new Client();
        $client->setAppKey('xxxx');
        $client->setSecret('xxxx');

        $request = new ApiQueryOrderRequest();
        $request->setStartTime(time() - 3600);
        $request->setEndTime(time());
        $request->setPage(1);
        $request->setLimit(20);
        $request->setQueryTimeType(1);
        $request->setBusinessLine([7]);

        return $client->execute($request);
    }
}
```

## 扩展
> 本库只实现了美团美天赚的自用接口，如果需要扩展，请参考以下步骤

1. 添加新的接口请求类，继承`Msmm\MtMtz\Requests\AbstractRequest`抽象类
2. 实现 `getApiMethodName` `getApiParams` 方法。
    > 如果返回值有定制结构需求，重写抽象类 `Msmm\MtMtz\Requests\AbstractRequest` 的 `getResult` 方法即可
3. 具体实现请参考 `Msmm\MtMtz\Requests\ApiQueryOrderRequest` 类
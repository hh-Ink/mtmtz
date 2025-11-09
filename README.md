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
    > 如果返回值有定制结构需求

    > 重写抽象类 `Msmm\MtMtz\Requests\AbstractRequest` 的 `getResult` 方法即可
3. 具体实现请参考 `Msmm\MtMtz\Requests\ApiQueryOrderRequest` 类

## PR
> 有api新增或参数新增或变化，欢迎提交PR

#### PR编码规则如下：
1. 命名规范
   - 类名采用 UpperCamelCase 命名法，如 ApiQueryOrderRequest
   - 属性名采用 lowerCamelCase 命名法，如 businessLine、startTime
   - 方法名采用 lowerCamelCase 命名法，如 getSid()、setBusinessLine()
2. 类结构组织
   - 类继承自 AbstractRequest 基类
   - 属性声明在类的开头，按照功能相关性分组排列
   - 属性访问控制使用 private 修饰符
   - getter/setter 方法成对出现，按属性顺序排列
   - 核心业务方法放在类的最后，如 getApiParams() 和 getApiMethodName()
3. 注释规范 
   - 每个属性都有详细的 PHPDoc 注释，包含：
   - 业务含义说明
   - 是否必须标识
   - 数据类型声明（@var 标签）
   - 枚举值说明（适用时）
   - 类级别有功能描述注释
   - 复杂业务逻辑有详细说明
4. 类型声明
   - 严格模式声明：declare(strict_types=1)
   - 属性类型要明确声明在注释里，是IDE可识别
   - 属性 set 和 get 方法入参和出参不可强制指定数据类型
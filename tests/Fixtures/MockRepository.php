<?php

namespace WechatWorkJssdkBundle\Tests\Fixtures;

use WechatWorkBundle\Entity\Corp;
use WechatWorkBundle\Repository\CorpRepository;

/**
 * 测试用的模拟 CorpRepository
 */
class MockRepository extends CorpRepository
{
    public function __construct()
    {
        // 空构造函数，避免依赖
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?object
    {
        if (isset($criteria['corpId'])) {
            $corp = new Corp();
            $corp->setCorpId($criteria['corpId']);

            return $corp;
        }

        return null;
    }
}

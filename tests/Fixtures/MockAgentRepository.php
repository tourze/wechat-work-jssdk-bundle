<?php

namespace WechatWorkJssdkBundle\Tests\Fixtures;

use WechatWorkBundle\Entity\Agent;
use WechatWorkBundle\Repository\AgentRepository;

/**
 * 测试用的模拟 AgentRepository
 */
class MockAgentRepository extends AgentRepository
{
    public function __construct()
    {
        // 空构造函数，避免依赖
    }

    public function findOneBy(array $criteria, ?array $orderBy = null): ?object
    {
        if (isset($criteria['corp'], $criteria['agentId'])) {
            $agent = new Agent();
            $agent->setAgentId($criteria['agentId']);
            $agent->setCorp($criteria['corp']);

            return $agent;
        }

        return null;
    }
}

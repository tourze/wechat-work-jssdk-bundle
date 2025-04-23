<?php

namespace WechatWorkJssdkBundle\Semantics;

class RedPacket implements SemanticsInterface
{
    public function getValue(): int
    {
        return 3;
    }

    public function getTitle(): string
    {
        return '红包';
    }
}

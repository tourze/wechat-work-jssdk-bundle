<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Semantics;

final class RedPacket implements SemanticsInterface
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

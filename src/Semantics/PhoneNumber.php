<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Semantics;

class PhoneNumber implements SemanticsInterface
{
    public function getValue(): int
    {
        return 1;
    }

    public function getTitle(): string
    {
        // TODO: Implement getTitle() method.
        return '手机号';
    }
}

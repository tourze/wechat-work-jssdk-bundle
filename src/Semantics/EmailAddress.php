<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Semantics;

final class EmailAddress implements SemanticsInterface
{
    public function getValue(): int
    {
        return 2;
    }

    public function getTitle(): string
    {
        return '邮箱地址';
    }
}

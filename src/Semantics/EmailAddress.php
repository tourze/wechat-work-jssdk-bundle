<?php

namespace WechatWorkJssdkBundle\Semantics;

class EmailAddress implements SemanticsInterface
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

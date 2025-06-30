<?php

namespace WechatWorkJssdkBundle\Semantics;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'wechat-work.semantics')]
interface SemanticsInterface
{
    /**
     * @return string 语义标题
     */
    public function getTitle(): string;

    /**
     * @return int 语义值
     */
    public function getValue(): int;
}

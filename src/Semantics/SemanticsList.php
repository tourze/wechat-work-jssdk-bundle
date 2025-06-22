<?php

namespace WechatWorkJssdkBundle\Semantics;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Tourze\EnumExtra\SelectDataFetcher;

#[Autoconfigure(public: true)]
class SemanticsList implements SelectDataFetcher
{
    public function __construct(#[TaggedIterator('wechat-work.semantics')] private readonly iterable $providers)
    {
    }

    public function genSelectData(): iterable
    {
        $result = [];
        foreach ($this->providers as $item) {
            /* @var SemanticsInterface $item */
            $result[] = [
                'label' => $item->getTitle(),
                'text' => $item->getTitle(),
                'value' => $item->getValue(),
                'name' => $item->getTitle(),
            ];
        }

        array_multisort(array_column($result, 'value'), SORT_ASC, $result);

        return $result;
    }
}

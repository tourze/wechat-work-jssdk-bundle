<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Semantics;

use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Tourze\EnumExtra\SelectDataFetcher;

#[Autoconfigure(public: true)]
final class SemanticsList implements SelectDataFetcher
{
    /**
     * @param iterable<SemanticsInterface> $providers
     */
    public function __construct(#[AutowireIterator(tag: 'wechat-work.semantics')] private readonly iterable $providers)
    {
    }

    /**
     * @return array<int, array{label: string, text: string, value: string, name: string}>
     */
    public function genSelectData(): iterable
    {
        $result = [];
        foreach ($this->providers as $item) {
            /* @var SemanticsInterface $item */
            $result[] = [
                'label' => $item->getTitle(),
                'text' => $item->getTitle(),
                'value' => (string) $item->getValue(),
                'name' => $item->getTitle(),
            ];
        }

        array_multisort(array_column($result, 'value'), SORT_ASC, $result);

        return $result;
    }
}

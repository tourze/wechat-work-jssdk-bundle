<?php

declare(strict_types=1);

namespace WechatWorkJssdkBundle\Exception;

final class AgentNotSetException extends \Exception
{
    public function __construct(string $message = 'Agent is not set', int $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

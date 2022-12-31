<?php

namespace App\Service\NewsParser\Gateway\GatewayExample;

use App\Service\NewsParser\Exception\NewsParserException;
use App\Service\NewsParser\Contract\TerminalInterface;
//use App\Service\NewsParser\Vo\NewsPostVo;

class Terminal implements TerminalInterface
{
    public const GATEWAY_NAME = 'EXAMPLE';

    public function getTerminalName(): string
    {
        return self::GATEWAY_NAME;
    }

    /**
     * @throws NewsParserException
     */
    public function getLatestNews(): array
    {
        return [];
    }

    /**
     * @throws NewsParserException
     */
    public function getNewsPostContent(string $url): array
    {
        // todo add mapper

        return [];
    }
}

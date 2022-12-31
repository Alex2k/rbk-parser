<?php

namespace App\Service\NewsParser\Contract;

//use App\Service\NewsParser\Vo\NewsPostVo;

interface TerminalInterface
{
    public function getTerminalName(): string;

    /**
     * @return int[]
     */
    public function getLatestNews(): array;

    public function getNewsPostContent(string $url): array;
}

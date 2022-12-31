<?php

namespace App\Service\NewsParser\Gateway\Rbk;

use App\Service\NewsParser\Exception\NewsParserException;
use App\Service\NewsParser\Contract\TerminalInterface;
//use App\Service\NewsParser\Vo\NewsPostVo;
//use Throwable;

class Terminal implements TerminalInterface
{
    public const GATEWAY_NAME = 'RBK';

    private Sdk $sdk;
    private HtmlParser $htmlParser;

    public function __construct(
        Sdk $sdk,
        HtmlParser $htmlParser
    ) {
        $this->sdk = $sdk;
        $this->htmlParser = $htmlParser;
    }

    public function getTerminalName(): string
    {
        return self::GATEWAY_NAME;
    }

    /**
     * @throws NewsParserException
     */
    public function getLatestNews(): array
    {
        $response = $this->sdk->parseMainPageContent();

        if ($response->getStatusCode() !== 200) {
            throw new NewsParserException('Bad response status code: ' . $response->getStatusCode());
        }

        $htmlContent = $response->getBody()->getContents();

        return $this->htmlParser->parseMainPageNewsList($htmlContent);
    }

    /**
     * @throws NewsParserException
     */
    public function getNewsPostContent(string $url): array
    {
        $response = $this->sdk->parseByUrl($url);

        if ($response->getStatusCode() !== 200) {
            throw new NewsParserException('Bad response status code: ' . $response->getStatusCode());
        }

        $htmlContent = $response->getBody()->getContents();

        return $this->htmlParser->parseNewsPostPageContent($htmlContent);
    }
}

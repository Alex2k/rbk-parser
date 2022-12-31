<?php

namespace App\Service\NewsParser\Gateway\Rbk;

use App\Service\NewsParser\Exception\NewsParserException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class Sdk
{
    private const ENTRY_POINT = 'https://www.rbc.ru';

    /**
     * @throws NewsParserException
     */
    public function parseMainPageContent(): ResponseInterface
    {
        return $this->parseByUrl(self::ENTRY_POINT);
    }

    /**
     * @throws NewsParserException
     */
    public function parseByUrl(string $url): ResponseInterface
    {
        try {
            $client = new Client();

            $response = $client->request(
                'GET',
                $url
            );
        } catch (Throwable $throwable) {
            throw new NewsParserException($throwable->getMessage());
        }

        return $response;
    }
}

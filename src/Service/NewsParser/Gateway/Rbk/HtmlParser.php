<?php

namespace App\Service\NewsParser\Gateway\Rbk;

use App\Service\NewsParser\Exception\NewsParserException;
use DomDocument;
use DOMNode;
use DomNodeList;
use DOMXpath;

class HtmlParser
{
    public function parseMainPageNewsList(string $html): ?array
    {
        $feedItemsData = [];

        $dom = new DOMDocument();
        $dom->loadHTML($html);

        $xpath = new DOMXPath($dom);
        $feedNodes = $xpath->query("//*[contains(@class, 'news-feed')]");

        if ($feedNodes->length > 0) {
            $feedBaseNode = $feedNodes->item(0);

            if ($feedBaseNode) {
                /** @var DOMNode[]|DomNodeList|false $feedItemNodes */
                $feedItemNodes = $xpath->query("//*[contains(@class, 'news-feed__item ')]", $feedBaseNode);

                foreach ($feedItemNodes as $i => $feedItemNode) {
                    $feedItemNodeAttributes = $feedItemNode->attributes;

                    $href = $feedItemNodeAttributes
                        ->getNamedItem('href')
                        ->textContent;

                    if (strpos($href, 'https://www.rbc.ru') !== 0) {
                        continue;
                    }

                    $feedItemsData[] = [
                        'remote_id' => $feedItemNodeAttributes
                            ->getNamedItem('id')
                            ->textContent,
                        'remote_url' => $feedItemNodeAttributes
                            ->getNamedItem('href')
                            ->textContent,
                    ];
                }
            }
        }

        return $feedItemsData;
    }

    /**
     * @throws NewsParserException
     */
    public function parseNewsPostPageContent(string $html): ?array
    {
        $contentData = [
            'image' => null,
            'text' => null,
        ];

        $dom = new DOMDocument();
        $dom->loadHTML($html);

        $xpath = new DOMXPath($dom);
        $contentNodes = $xpath->query(
            "//*[contains(@class, 'article__content')]"
        );

        if ($contentNodes->length > 0) {
            $contentBaseNode = $contentNodes->item(0);

            if ($contentBaseNode) {
                // Title
                /** @var DOMNode[]|DomNodeList|false $contentTitleNodes */
                $contentTitleNodes = $xpath->query(
                    "//*[contains(@class, 'article__header__title-in')]",
                    $contentBaseNode
                );

                if (! $contentTitleNodes->length) {
                    throw new NewsParserException('Title not found');
                }

                /** @var DOMNode $contentTitleNode */
                $contentTitleNode = $contentTitleNodes->item(0);
                $contentData['title'] = trim($contentTitleNode->textContent);

                // Date
                /** @var DOMNode[]|DomNodeList|false $contentDateNodes */
                $contentDateNodes = $xpath->query(
                    "//*[contains(@class, 'article__header__date')]",
                    $contentBaseNode
                );

                if (! $contentDateNodes->length) {
                    throw new NewsParserException('Date not found');
                }

                /** @var DOMNode $contentDateNode */
                $contentDateNode = $contentDateNodes->item(0);
                $contentData['date'] = $contentDateNode
                    ->attributes
                    ->getNamedItem('datetime')
                    ->nodeValue;

                // Image
                /** @var DOMNode[]|DomNodeList|false $contentImageNodes */
                $contentImageNodes = $xpath->query(
                    "//*[contains(@class, 'article__main-image__wrap')]",
                    $contentBaseNode
                );

                if ($contentImageNodes->length) {
                    /** @var DOMNode $contentImageNode */
                    $contentImageNode = $contentImageNodes->item(0);

                    /** @var DOMNode[]|DomNodeList|false $contentImageSourceNodes */
                    $contentImageSourceNodes = $xpath->query(
                        "//*[contains(@class, 'smart-image__img')]",
                        $contentImageNode
                    );

                    if (! $contentImageSourceNodes->length) {
                        throw new NewsParserException('Image not found');
                    }

                    /** @var DOMNode $contentImageSourceNode */
                    $contentImageSourceNode = $contentImageSourceNodes->item(0);
                    $contentData['image'] = $contentImageSourceNode
                        ->attributes
                        ->getNamedItem('src')
                        ->nodeValue;
                }

                // Text
                /** @var DOMNode[]|DomNodeList|false $contentTextNodes */
                $contentTextNodes = $xpath->query(
                    "//*[contains(@class, 'article__text')]",
                    $contentBaseNode
                );

                if ($contentTextNodes->length) {
                    /** @var DOMNode $contentTextNode */
                    $contentTextBaseNode = $contentTextNodes->item(0);

                    /** @var DOMNode[]|DomNodeList|false $contentTextItemNodes */
                    $contentTextItemNodes = $xpath->query(
                        "//p",
                        $contentTextBaseNode
                    );

                    if ($contentTextItemNodes->length) {
                        foreach ($contentTextItemNodes as $contentTextItemNode) {
                            $text = trim(
                                str_replace(
                                    ["\r", "\n"],
                                    '',
                                    $contentTextItemNode->textContent
                                )
                            );

                            if (!empty($text)) {
                                $contentData['text'][] = $text;
                            }
                        }
                    }
                }
            }
        }

        $contentData['text'] = implode(PHP_EOL, $contentData['text']);

        return $contentData;
    }
}

<?php
namespace rafaelglikis\autogp\Scrapers;

use rafaelglikis\autogp\Helpers\HtmlHelper;
use rafaelglikis\autogp\Scrapers\Interfaces\Crawler;

abstract class EntryCrawler  implements Crawler
{
    private $baseUrl;
    private $stopUrl;
    private $entriesContent = [];

    public function __construct(string $baseUrl, string $stopUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->stopUrl = $stopUrl;
    }

    abstract public function getNextPageUrl(string $html): string;
    abstract public function getPageEntries(string $html): array;
    abstract public function getEntryContent(string $entryUrl);

    public function startCrawling($stopAt = 0)
    {
        $stopHtml = HtmlHelper::getHtmlFrom($this->stopUrl);
        $count = 0;
        echo "Crawling From : $this->baseUrl \n";
        $nextUrl = $this->baseUrl;

        while($stopAt == 0 || $count != $stopAt)
        {
            $html = HtmlHelper::getHtmlFrom($nextUrl);
            if($html === $stopHtml) break;

            $entries = $this->getPageEntries($html);

            foreach ($entries as $entry)
            {
                $content = $this->getEntryContent($entry);
                $this->entriesContent[] = $content;
                var_dump($content);
            }

            print_r($entries);
            $nextUrl = $this->getNextPageUrl($html);
            echo "Next Url: $nextUrl \n";
            $count++;
        }
    }

    /***************************************************************
     *                      ADDERS - GETTERS
     ***************************************************************/

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getStopUrl(): string
    {
        return $this->stopUrl;
    }


    public function setStopUrl(string $stopUrl)
    {
        $this->stopUrl = $stopUrl;
    }

    public function getEntriesContent(): array
    {
        return $this->entriesContent;
    }

    public function setEntriesContent(array $entriesContent)
    {
        $this->entriesContent = $entriesContent;
    }

    public function addEntriesContent(array $entriesContent)
    {
        $this->entriesContent[] = $entriesContent;
    }
}
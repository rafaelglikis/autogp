<?php

use PHPUnit\Framework\TestCase;
use rafaelglikis\autogp\Scrapers\ArticleScraper;
use examples\MyArticleScraper;

class ArticleScraperTest extends TestCase
{
    private static $scraper;

    public static function setUpBeforeClass()
    {
        ArticleScraperTest::$scraper = new MyArticleScraper();
    }
}
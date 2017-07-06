<?php
namespace examples;
require_once("../vendor/autoload.php");

use rafaelglikis\autogp\Scrapers\ArticleScraper;


class MyArticleScraper extends ArticleScraper
{

    public static function extractLastArticleFromCategory($categoryUrl): string
    {
        // TODO: Implement extractLastArticleFromCategory() method.
    }
}

$scraper = new MyArticleScraper();
$scraper->addArticleUrl("../tests/fixtures/test.html");
$scraper->extractArticles();
$articles = $scraper->getArticles();

foreach ($articles as $article)
{
    print $article->getTitle() . "\n";
    print $article->getImgUrl() . "\n";
    print $article->getContent() . "\n";
}
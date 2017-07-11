<?php
namespace examples;
require_once("../vendor/autoload.php");

use rafaelglikis\autogp\Datatypes\Category;
use rafaelglikis\autogp\Helpers\HtmlHelper;
use rafaelglikis\autogp\Helpers\TextHelper;
use rafaelglikis\autogp\Scrapers\ArticleScraper;


class MyArticleScraper extends ArticleScraper
{

    public function extractLastArticleFromCategory($categoryUrl): string
    {
        $html = HtmlHelper::getHtmlFrom("$categoryUrl");

        $aTag = TextHelper::strCut($html, "<p class=\"story-body__read-full-article\">", "</p>");

        $articleUrl = HtmlHelper::extractLink($aTag);
        return $articleUrl;
    }
}

$scraper = new MyArticleScraper();
$scraper->addArticleUrl("../tests/fixtures/test.html");
$scraper->addCategory(new Category("../tests/fixtures/category.html"));
$articles = $scraper->extractArticles();


foreach($articles as $article)
{
    print $article->getTitle() . "\n";
    print $article->getImgUrl() . "\n";
    print $article->getContent() . "\n";
}


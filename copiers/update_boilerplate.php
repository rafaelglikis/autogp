<?php
require_once("../vendor/autoload.php");

use rafaelglikis\autogp\Copiers\Copier;
use rafaelglikis\autogp\Datatypes\Category;
use rafaelglikis\autogp\Datatypes\CopierCategory;
use rafaelglikis\autogp\DestinationSites\WordpressDestinationSite;
use rafaelglikis\autogp\Scrapers\ArticleScraper;
use rafaelglikis\autogp\Datatypes\Article;
use rafaelglikis\autogp\Helpers\HtmlHelper;
use rafaelglikis\autogp\Helpers\TextHelper;

class TestArticleScraper extends ArticleScraper
{
    public function extractLastArticleFromCategory($categoryUrl): string
    {
        $html = HtmlHelper::getHtmlFrom("$categoryUrl");
        $aTag = TextHelper::strCut($html, "<p class=\"story-body__read-full-article\">", "</p>");
        $articleUrl = HtmlHelper::extractLink($aTag);

        return $articleUrl;
    }
}

function printLastArticleUrl($scraper, $sourceCategoryUrl)
{
    print $scraper->extractLastArticleFromCategory($sourceCategoryUrl);
}

function dumpLastArticle($scraper, $sourceCategoryUrl)
{
    $scraper->addCategory(new Category($sourceCategoryUrl));
    $article = $scraper->extractArticles()[0];
    /** @var Article $article */
    $article->dumpArticleHtml();
}

function update($scraper, $destinationSite, $categories, $publish = false)
{
    // Creating Copier
    $copier = new Copier("test_to_test", $scraper, $destinationSite);
    $copier->setCategories($categories);

    $copier->update($publish);
}

// Creating Scraper Object
$scraper = new TestArticleScraper();
$sourceCategoryUrl = '../tests/fixtures/category.html';

printLastArticleUrl($scraper,$sourceCategoryUrl);
dumpLastArticle($scraper, $sourceCategoryUrl);

// Creating DestinationSite Object
$destinationSite = new WordpressDestinationSite("/var/www/html/");

// Adding Categories
$copierCategories= [
    new CopierCategory($sourceCategoryUrl, [4,5]),
];





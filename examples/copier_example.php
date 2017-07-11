<?php
require_once("../vendor/autoload.php");

use rafaelglikis\autogp\Scrapers\TestArticleScraper;
use rafaelglikis\autogp\Copiers\Copier;
use rafaelglikis\autogp\DestinationSites\WordpressDestinationSite;
use rafaelglikis\autogp\Datatypes\CopierCategory;
use rafaelglikis\autogp\Datatypes\Article;

// Creating Scraper Object
$scraper = new TestArticleScraper();

// Adding article url
$scraper->addArticleUrl("../tests/fixtures/test.html");

// Adding Article
$article = new Article();
$article->setTitle("Test");
$article->setImgUrl("../tests/fixtures/images/potato.jpg");
$article->setContent("Lorem Ipsum testus salatius");
$article->setDestinationCategories([4]);
$scraper->addArticle($article);


// Adding Categories
$categories= [
    new CopierCategory("../tests/fixtures/category.html", [4,5]),
    new CopierCategory("../tests/fixtures/category.html", [6,7]),
    new CopierCategory("../tests/fixtures/category.html", [8,9]),
    new CopierCategory("../tests/fixtures/category.html", [10,11]),
];
/* @var $categories CopierCategory */
foreach ($categories as $category) $scraper->addCategory($category);


// Creating DestinationSite Object
$destinationSite = new WordpressDestinationSite("/var/www/html/");

// Creating Copier
$copier = new Copier("test_to_test", $scraper, $destinationSite);

// Copy
$copier->update();

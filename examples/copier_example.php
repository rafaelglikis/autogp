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

// Creating DestinationSite Object
$destinationSite = new WordpressDestinationSite("/var/www/html/");

// Creating Copier
$copier = new Copier("test_to_test", $scraper, $destinationSite);

// Adding Categories
$categories= [
    new CopierCategory("../tests/fixtures/category.html", [4,5]),
    new CopierCategory("../tests/fixtures/category.html", [6,7]),
    new CopierCategory("../tests/fixtures/category.html", [8,9]),
    new CopierCategory("../tests/fixtures/category.html", [10,11]),
];

$copier->setCategories($categories);

// Copy
$copier->update();

// Copy Draft
//$copier->update(false);

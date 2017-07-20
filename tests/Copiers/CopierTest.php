<?php

use PHPUnit\Framework\TestCase;
use rafaelglikis\autogp\DestinationSites\TestWordpressDestinationSite;
use rafaelglikis\autogp\Scrapers\TestArticleScraper;
use rafaelglikis\autogp\Copiers\TestCopier;
use rafaelglikis\autogp\DestinationSites\WordpressDestinationSite;
use rafaelglikis\autogp\Datatypes\CopierCategory;
use rafaelglikis\autogp\Datatypes\Article;


class CopierTest extends TestCase
{
    private static $destinationSite;
    private $title = "test";
    private $imageUrl = "fixtures/images/potato.jpg";
    private $categoryIds = [1,2,3];
    private $wpStatus = "draft";
    private $content = "This is a test";

    public static function setUpBeforeClass()
    {

    }

    public function testCopier()
    {
        $this->setOutputCallback(function() {});

        // Creating Scraper Object
        $scraper = new TestArticleScraper();

        // Adding article url
        $scraper->addArticleUrl("fixtures/test.html");

        // Creating DestinationSite Object
        $destinationSite = new TestWordpressDestinationSite("fixtures/wordpress/");


        // Creating Copier
        $copier = new TestCopier("test_to_test", $scraper, $destinationSite);

        $this->assertEquals("test_to_test", $copier->getCopierName());
        $this->assertEquals($scraper, $copier->getSourceSiteScraper());
        $this->assertEquals($destinationSite, $copier->getDestinationSite());

        // Adding Categories
        $categories= [
            new CopierCategory("fixtures/category.html", [4,5]),
            new CopierCategory("fixtures/category.html", [6,7]),
            new CopierCategory("fixtures/category.html", [8,9]),
            new CopierCategory("fixtures/category.html", [10,11]),
        ];

        $copier->setCategories($categories);

        $this->assertEquals($categories, $copier->getCategories());

        $this->assertTrue($copier->update());
    }
}



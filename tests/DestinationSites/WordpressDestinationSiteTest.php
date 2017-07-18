<?php

use PHPUnit\Framework\TestCase;
use rafaelglikis\autogp\DestinationSites\TestWordpressDestinationSite;
use \rafaelglikis\autogp\Datatypes\Article;


class WordpressDestinationSiteTest extends TestCase
{
    private static $destinationSite;
    private $title = "test";
    private $imageUrl = "fixtures/images/potato.jpg";
    private $categoryIds = [1,2,3];
    private $wpStatus = "draft";
    private $content = "This is a test";

    public static function setUpBeforeClass()
    {
        WordpressDestinationSiteTest::$destinationSite = new TestWordpressDestinationSite("fixtures/wordpress/");

    }

    public function testWpPath()
    {
        $path = WordpressDestinationSiteTest::$destinationSite->getWpPath();
        $this->assertEquals($path, "fixtures/wordpress/");
    }

    public function testInsertPost()
    {
        $this->setOutputCallback(function() {});

        $result = WordpressDestinationSiteTest::$destinationSite->insertPost($this->title,  $this->imageUrl, $this->content, $this->wpStatus, $this->categoryIds);
        $this->assertEquals($result['title'], $this->title);
        $this->assertEquals($result['image_url'], $this->imageUrl);
        $this->assertEquals($result['content'], $this->content);
        $this->assertEquals($result['status'], $this->wpStatus);
        $this->assertEquals($result['category_ids'], $this->categoryIds);
    }

    public function testInsertPublishedPost()
    {
        $this->setOutputCallback(function() {});

        $result = WordpressDestinationSiteTest::$destinationSite->insertPublishedPost($this->title,  $this->imageUrl, $this->content, $this->categoryIds);
        $this->assertEquals($result['title'], $this->title);
        $this->assertEquals($result['image_url'], $this->imageUrl);
        $this->assertEquals($result['content'], $this->content);
        $this->assertEquals($result['status'], "published");
        $this->assertEquals($result['category_ids'], $this->categoryIds);

    }

    public function testInsertDraftPost()
    {
        $this->setOutputCallback(function() {});

        $result = WordpressDestinationSiteTest::$destinationSite->insertDraftPost($this->title,  $this->imageUrl, $this->content, $this->categoryIds);
        $this->assertEquals($result['title'], $this->title);
        $this->assertEquals($result['image_url'], $this->imageUrl);
        $this->assertEquals($result['content'], $this->content);
        $this->assertEquals($result['status'], "draft");
        $this->assertEquals($result['category_ids'], $this->categoryIds);
    }

    public function testInsertPublishedArticle()
    {
        $this->setOutputCallback(function() {});

        $article = new Article();
        $article->setTitle($this->title);
        $article->setImgUrl($this->imageUrl);
        $article->setContent($this->content);

        $result = WordpressDestinationSiteTest::$destinationSite->insertPublishedArticle($article, $this->categoryIds);
        $this->assertEquals($result['title'], $this->title);
        $this->assertEquals($result['image_url'], $this->imageUrl);
        $this->assertEquals($result['content'], $this->content);
        $this->assertEquals($result['status'], "published");
        $this->assertEquals($result['category_ids'], $this->categoryIds);

        $categoryIds = [2,3,4];
        $article->setDestinationCategories($categoryIds);
        $result = WordpressDestinationSiteTest::$destinationSite->insertPublishedArticle($article);
        $this->assertEquals($result['category_ids'], $categoryIds);

    }

    public function testInsertDraftArticle()
    {
        $this->setOutputCallback(function() {});

        $article = new Article();
        $article->setTitle($this->title);
        $article->setImgUrl($this->imageUrl);
        $article->setContent($this->content);

        $result = WordpressDestinationSiteTest::$destinationSite->insertDraftArticle($article, $this->categoryIds);
        $this->assertEquals($result['title'], $this->title);
        $this->assertEquals($result['image_url'], $this->imageUrl);
        $this->assertEquals($result['content'], $this->content);
        $this->assertEquals($result['status'], "draft");
        $this->assertEquals($result['category_ids'], $this->categoryIds);

        $categoryIds = [2,3,4];
        $article->setDestinationCategories($categoryIds);
        $result = WordpressDestinationSiteTest::$destinationSite->insertDraftArticle($article);
        $this->assertEquals($result['category_ids'], $categoryIds);
    }
}



<?php

use PHPUnit\Framework\TestCase;
use rafaelglikis\autogp\Scrapers\TestArticleScraper;
use rafaelglikis\autogp\Datatypes\Category;

class ArticleScraperTest extends TestCase
{
    const TITLE = "Why people believe the myth of 'plastic rice' - BBC News";
    const IMAGE = "../tests/fixtures/images/potato.jpg";
    const MAIN_CONTENT_FILE = "fixtures/main_content.html";
    const CATEGORY_FILE = "fixtures/category.html";
    const TEST_FILE = "fixtures/test.html";

    public function testExtractArticle()
    {
        $scraper = new TestArticleScraper();

        $scraper->addArticleUrl(ArticleScraperTest::TEST_FILE);

        $scraper->extractArticles();

        $article = $scraper->getArticles()[0];

        $this->assertEquals($article->getTitle(), ArticleScraperTest::TITLE);
        $this->assertEquals($article->getImgUrl(), ArticleScraperTest::IMAGE);
        $this->assertEquals($article->getContent(), file_get_contents(ArticleScraperTest::MAIN_CONTENT_FILE));
    }

    public function testExtractArticlesByCategory()
    {
        $scraper = new TestArticleScraper();

        // Adding Categories
        $scraper->addCategory(new Category(ArticleScraperTest::CATEGORY_FILE));
        $scraper->addCategory(new Category(ArticleScraperTest::CATEGORY_FILE));
        $scraper->addCategory(new Category(ArticleScraperTest::CATEGORY_FILE));

        // Extracting
        $articles = $scraper->extractArticles();

        foreach($articles as $article)
        {
            $this->assertEquals($article->getTitle(), ArticleScraperTest::TITLE);
            $this->assertEquals($article->getImgUrl(), ArticleScraperTest::IMAGE);
            $this->assertEquals($article->getContent(), file_get_contents(ArticleScraperTest::MAIN_CONTENT_FILE));
        }

        $this->assertEquals(3,sizeof($articles));
    }

    public function testExtractArticles()
    {
        $scraper = new TestArticleScraper();

        // Adding Articles
        $scraper->addArticleUrl(ArticleScraperTest::TEST_FILE);
        $scraper->addArticleUrl(ArticleScraperTest::TEST_FILE);

        // Adding Categories
        $scraper->addCategory(new Category(ArticleScraperTest::CATEGORY_FILE));
        $scraper->addCategory(new Category(ArticleScraperTest::CATEGORY_FILE));
        $scraper->addCategory(new Category(ArticleScraperTest::CATEGORY_FILE));
        $scraper->addCategory(new Category(ArticleScraperTest::CATEGORY_FILE));

        // Extracting
        $articles = $scraper->extractArticles();

        foreach($articles as $article)
        {
            $this->assertEquals($article->getTitle(), ArticleScraperTest::TITLE);
            $this->assertEquals($article->getImgUrl(), ArticleScraperTest::IMAGE);
            $this->assertEquals($article->getContent(), file_get_contents(ArticleScraperTest::MAIN_CONTENT_FILE));
        }

        $this->assertEquals(6,sizeof($articles));
    }
}


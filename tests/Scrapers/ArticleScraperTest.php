<?php

use PHPUnit\Framework\TestCase;
use rafaelglikis\autogp\Scrapers\TestArticleScraper;

class ArticleScraperTest extends TestCase
{
    public function testExtractArticle()
    {
        $scraper = new TestArticleScraper();
        $scraper->addArticleUrl("fixtures/test.html");
        $scraper->extractArticles();

        $article = $scraper->getArticles()[0];

        $this->assertEquals($article->getTitle(),"Why people believe the myth of 'plastic rice' - BBC News");
        $this->assertEquals($article->getImgUrl(), "https://ichef.bbci.co.uk/news/1024/cpsprodpb/8688/production/_96804443_riceball3.jpg");
        $this->assertEquals($article->getContent(), file_get_contents("fixtures/main_content.html"));
    }
}


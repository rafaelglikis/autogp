<?php
use PHPUnit\Framework\TestCase;

use rafaelglikis\autogp\Scrapers\TestArticleScraper;
use rafaelglikis\autogp\Testers\Tester;

class TesterTest extends TestCase
{
    public function testTester()
    {
        $this->setOutputCallback(function() {});

        // Testing Articles that not exists
        /** @var  $testers TestArticleScraper*/
        $testers = array();
        $testers["test_test"] = new TestArticleScraper();
        $testers["test_test"]->addArticleUrl("fixtures/test.html");
        /** @var  $article TestArticleScraper*/
        foreach ($testers as $tester => $article)
        {
            $article = $article->extractArticles()[0];
            $this->assertNotTrue((new Tester($tester . "_title"))->test($article->getTitle(), false));
            $this->assertNotTrue((new Tester($tester . "_content"))->test($article->getContent(), false));
            $this->assertNotTrue((new Tester($tester . "_imageurl"))->test($article->getImgUrl(), false));
        }

        //Adding Articles
        /** @var  $testers TestArticleScraper*/
        $testers = array();
        $testers["test_test"] = new TestArticleScraper();
        $testers["test_test"]->addArticleUrl("fixtures/test.html");
        /** @var  $article TestArticleScraper*/
        foreach ($testers as $tester => $article)
        {
            print "[i] Initializing $tester \n";
            $article = $article->extractArticles()[0];
            (new Tester($tester . "_title"))->initializeTester($article->getTitle());
            (new Tester($tester . "_content"))->initializeTester($article->getContent());
            (new Tester($tester . "_imageurl"))->initializeTester($article->getImgUrl());
            print "[i] Done $tester \n";
        }

        // Testing Articles that exists
        /** @var  $testers TestArticleScraper*/
        $testers = array();
        $testers["test_test"] = new TestArticleScraper();
        $testers["test_test"]->addArticleUrl("fixtures/test.html");
        /** @var  $article TestArticleScraper*/
        foreach ($testers as $tester => $article)
        {
            $article = $article->extractArticles()[0];
            $this->assertTrue((new Tester($tester . "_title"))->test($article->getTitle(), false));
            $this->assertTrue((new Tester($tester . "_content"))->test($article->getContent(), false));
            $this->assertTrue((new Tester($tester . "_imageurl"))->test($article->getImgUrl(), false));
        }

    }
}



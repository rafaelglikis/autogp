<?php
namespace examples;
require_once("../vendor/autoload.php");

use rafaelglikis\autogp\Scrapers\TestArticleScraper;
use rafaelglikis\autogp\Testers\Tester;



/** @var  $testers TestArticleScraper*/
$testers = array();
print "[i] Initializing started \n";
print "[i] Fetching data . . . \n";
$testers["test_test"] = new TestArticleScraper();
$testers["test_test"]->addArticleUrl("../tests/fixtures/test.html");

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


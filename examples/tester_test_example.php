<?php
namespace examples;
require_once("../vendor/autoload.php");

use rafaelglikis\autogp\Scrapers\TestArticleScraper;
use rafaelglikis\autogp\Testers\Tester;


/** @var  $testers TestArticleScraper*/
$testers = array();
print "[i] Testing started \n";
print "[i] Fetching data . . . \n";
$testers["test_test"] = new TestArticleScraper();
$testers["test_test"]->addArticleUrl("../tests/fixtures/test.html");

/** @var  $article TestArticleScraper*/
foreach ($testers as $tester => $article)
{
    print "[i] Testing $tester \n";
    $article = $article->extractArticles()[0];
    (new Tester($tester . "_title"))->test($article->getTitle());
    (new Tester($tester . "_content"))->test($article->getContent());
    (new Tester($tester . "_imageurl"))->test($article->getImgUrl());
    print "[i] Done $tester \n";
}

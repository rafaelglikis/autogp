<?php
namespace examples;
require_once("../vendor/autoload.php");

use rafaelglikis\autogp\DestinationSites\WordpressDestinationSite;

$wordpress = new WordpressDestinationSite("/var/www/html/");

$title = "Test";
$image = "http://images.wisegeek.com/potatoes-against-white-background.jpg";
$content = "Lorem Ipsum testus salatius";
/*
 * Category ids
 * select * from wp_terms;
 */
$categories = [4, 5, 6, 7];

$wordpress->insertPublishedPost($title, $image, $content, $categories);
//$wordpress->insertDraftPost($title, $image, $content);
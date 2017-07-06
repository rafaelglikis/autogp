<?php
require_once("vendor/autoload.php");

use rafaelglikis\autogp\Helpers\HtmlHelper;
use rafaelglikis\autogp\Helpers\TextHelper;

$html = HtmlHelper::getHtmlFrom("tests/fixtures/test.html");


//print HtmlHelper::fixHtml($html);
/*
$URL_REGEX = "|<a.*(?=href=\"([^\"]*)\")[^>]*>([^<]*)</a>|i";

if(preg_match_all($URL_REGEX, $html, $matches))
{
    echo 'Found a match';
    $i = 0;
    $urls = array();
    foreach ($matches[1] as $match)
    {
        $urls[trim($matches[2][$i])] = $matches[1][$i];
        $i++;
    }
    print_r($urls);
}
else
{
    echo 'No match found';
}
*/



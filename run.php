<?php
require_once("vendor/autoload.php");

use rafaelglikis\autogp\Helpers\HtmlHelper;

$html = HtmlHelper::getHtmlFrom("tests/samples/test.html");

print HtmlHelper::fixHtml($html);






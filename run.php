<?php
require_once("vendor/autoload.php");
use rafaelglikis\autogp\Helpers\HtmlHelper;

$html = HtmlHelper::getHtmlFrom("tests/test.html");

print HtmlHelper::findMainContent($html);

